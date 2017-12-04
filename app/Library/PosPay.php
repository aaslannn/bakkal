<?php
namespace App\Library;

class PosPay
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
		$this->pos->krediKartiAyarlari($conf['card_no'], $conf['card_date'], $conf['card_cvc']);
		$this->pos->siparisAyarlari($conf['amount'], $conf['order_id'], $conf['inst']);
		return $this->pos->odeme();
	}
}