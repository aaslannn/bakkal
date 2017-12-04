<?php
namespace App\Library;

class GarantiPay
{
	protected $pos,
		$bank = '';
	/**
	 * 
	 * @param string $bank
	 * @param array $conf array(
	 * 'isyerino'=>'', 'teminalno'=>'',
	 * 'kullanici'=>'', 'sifre'=>'', 'debug'=>''
	 * )
	 */
	public function __construct($bank, $conf = array())
	{
		if(!isset($conf['debug']))
			$conf['debug'] = true;
		$this->bank = $bank;
		$this->conf = $conf;
		switch($bank)
		{
			case 'yapikredi':
				$this->getYapikredi();
				break;
			case 'akbank':
			case 'finansbank':
			case 'isbank':
			case 'anadolubank':
			case 'halkbank':
			case 'garanti':
				$this->getEst();
				break;
			default: 
				throw new \Exception('Unsupported bank.');
				break;
		}
	}
	/**
	 * Yapı Kredi
	 * @return \SanalPos\PosInterface
	 */
	public function getYapikredi()
	{
		$this->pos = new \SanalPos\YapiKredi\Pos(new \Posnet, $this->conf['isyerino'], $this->conf['terminalno'], ($this->conf['debug']?'test':'production'));
		return $this->pos;
	}
	/**
	 * Est
	 * @return \SanalPos\PosInterface
	 */
	public function getEst()
	{
		$est = new \est($this->bank, $this->conf['isyerino'], $this->conf['kullanici'], $this->conf['sifre'], $this->conf['debug']);
		$this->pos = new \SanalPos\Est\Pos($est);
		return $this->pos;
	}
	/**
	 * 
	 * @param array $conf array('card_no'=>'','card_date'=>'','card_cvc'=>'', 'amount'=>'', 'order_id'=>'', 'inst'=>'')
	 * @return \SanalPos\PosSonucInterface
	 */
	public function pay($conf)
	{
        $sktAy  = substr($conf['card_date'], 0, 2);
        $sktYil = substr($conf['card_date'], 2, 2);

        $tutar  = number_format($conf['amount'], 2, '.', '');
        $tutar  = str_replace('.','',$tutar);

       /* $strSearch = array('.',',');
        $strReplace = array('','');
        $tutar  = str_replace($strSearch,$strReplace,$tutar);*/

        $strMode = "PROD";
        $strVersion = "v0.01";
        $strTerminalID = $this->conf['terminalno'];
        $strTerminalID_ = sprintf('%09d', $this->conf['terminalno']); //TerminalID basina 0 eklenerek 9 digite tamamlanmalidir.
        $strProvUserID = $this->conf['kullanici'];
        $strProvisionPassword = $this->conf['sifre']; //ProvUserID sifresi
        $strUserID = $this->conf['kullanici'];
        $strMerchantID = $this->conf['isyerino']; //Uye Isyeri Numarasi
        $strIPAddress = $_SERVER['REMOTE_ADDR'];  //Musteri IP
        $strEmailAddress = "info@petcici.com";
        $strOrderID = $conf['order_id'];
        $strInstallmentCnt = $this->conf['taksit']; //Taksit Sayisi. Bos gonderilirse taksit yapilmaz
        $strNumber = $conf['card_no'];
        $strExpireDate = $sktAy.$sktYil;
        $strCVV2 = $conf['card_cvc'];
        $strAmount = $tutar; //Islem Tutari 1.00 TL icin 100 gonderilmelidir.
        $strType = "sales";
        $strCurrencyCode = "949"; //949:TRL , 840:USD, 978:EUR
        $strCardholderPresentCode = "0";
        $strMotoInd = "N";
        $strHostAddress = "https://sanalposprov.garanti.com.tr/VPServlet";

        /**test**/
        /*$strMerchantID = '7000679';
        $strTerminalID = '30691297';
        $strTerminalID_ = '030691297';
        $strProvisionPassword = '123qweASD';
        $strUserID = 'PROVAUT';
        $strHostAddress = "https://sanalposprovtest.garanti.com.tr/VPServlet";*/
        /**test**/

        $SecurityData = strtoupper(sha1($strProvisionPassword.$strTerminalID_));
        $HashData = strtoupper(sha1($strOrderID.$strTerminalID.$strNumber.$strAmount.$SecurityData));
        $xml= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
        <GVPSRequest>
        <Mode>$strMode</Mode><Version>$strVersion</Version>
        <Terminal><ProvUserID>$strProvUserID</ProvUserID><HashData>$HashData</HashData><UserID>$strUserID</UserID><ID>$strTerminalID</ID><MerchantID>$strMerchantID</MerchantID></Terminal>
        <Customer><IPAddress>$strIPAddress</IPAddress><EmailAddress>$strEmailAddress</EmailAddress></Customer>
        <Card><Number>$strNumber</Number><ExpireDate>$strExpireDate</ExpireDate><CVV2>$strCVV2</CVV2></Card>
        <Order><OrderID>$strOrderID</OrderID><GroupID></GroupID><AddressList><Address><Type>S</Type><Name></Name><LastName></LastName><Company></Company><Text></Text><District></District><City></City><PostalCode></PostalCode><Country></Country><PhoneNumber></PhoneNumber></Address></AddressList></Order><Transaction><Type>$strType</Type><InstallmentCnt>$strInstallmentCnt</InstallmentCnt><Amount>$strAmount</Amount><CurrencyCode>$strCurrencyCode</CurrencyCode><CardholderPresentCode>$strCardholderPresentCode</CardholderPresentCode><MotoInd>$strMotoInd</MotoInd><Description></Description><OriginalRetrefNum></OriginalRetrefNum></Transaction>
        </GVPSRequest>";

        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $strHostAddress);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS, "data=".$xml);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $results = curl_exec($ch);
        curl_close($ch);

        /*echo "<b>Giden Istek </b><br />";
        echo $xml;
        echo "<br /><b>Gelen Yanit </b><br />";
        echo $results;*/

        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser,$results,$vals,$index);
        xml_parser_free($xml_parser);

        $return['strReasonCodeValue'] = $vals[$index['REASONCODE'][0]]['value']; //ReasonCode degeri
        $return['strErrorMessage'] = @$vals[$index['ERRORMSG'][0]]['value']; //hata
        $return['strErrorMessageDetails'] = @$vals[$index['SYSERRMSG'][0]]['value']; //hata detay
        return $return;

       /* echo "<br /><b>Islem Sonucu : ".$strReasonCodeValue."</b><br />";
        if($strReasonCodeValue == "00"){
            echo "İşlem Başarılı";
        } else {
            echo "İşlem Başarısız";
        }*/
	}
}