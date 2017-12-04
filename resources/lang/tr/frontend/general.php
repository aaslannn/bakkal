<?php
/**
* Language file for general strings
*
*/

use App\Translation;
$translates = Translation::lists('lang_tr', 'slug')->toArray();
return $translates;


/*
return array(
	'home'			=> 'Anasayfa',
	'hakkimizda'	=> 'Hakkımızda',
	'iletisim'		=> 'İletişim',
	'yardim'		=> 'Yardım',
	'searchingProduct'	=> 'Aradığınız Ürün',
	'kategorisec'	=> 'Kategori Seç',
	'ara'			=> 'Ara',

	'uyegirisi'		=> 'Üye Girişi',
	'yeniuye'		=> 'Yeni Üye',
	'sepetim'		=> 'Sepetim',
	'uyebilgilerim'	=> 'Üye Bilgilerim',
	'alisverissepetim'=>'Alışveriş Sepetim',
	'siparislerim'	=> 'Siparişlerim',
	'favoriurunlerim'=>'Favori Ürünlerim',
	'adresdefteri'	=> 'Adres Defteri',
	'cikis'			=> 'Çıkış',

	'encoksatan'	=> 'En Çok Satanlar',
	'indirimurunler'=> 'İndirimdeki Ürünler',
	'vitrinurunler'	=> 'Vitrindeki Ürünler',
	'new'			=> 'Yeni',
	'discount'		=> 'İndirim',
	'sponsor'		=> 'Sponsor',

	'yes' 			=> 'Evet',
	'no'  			=> 'Hayır',
    'noresults'  	=> 'Sonuç Yok.',

	'tumkategoriler'=> 'Tüm Kategoriler',
	'SAYFALAR'		=> 'SAYFALAR',
	'KATEGORILER'	=> 'KATEGORİLER',
	'ILETISIM'		=> 'İLETİŞİM',
	'SOSYALMEDYA'	=> 'SOSYAL MEDYA',
	'SPONSOR'		=> 'SPONSOR',

	'tel'			=> 'Tel',
	'fax'			=> 'Faks',
	'email'			=> 'E-Mail',
	'copyright'		=> 'Tüm hakları saklıdır. Sitede yayınlanan görseller ve içerikler izin alınmadan kullanılamaz. <br/>Bu site :host hizmetidir.',
	'cancel'		=> 'İptal',
	'ok'			=> 'Tamam',
	'notamemberyet'	=> 'Henüz üye olmadınız mı? <b>Hemen üye olun.</b>',
	'existmember'	=> 'Üyeliğiniz var mı? <b>Hemen giriş yapın.</b>',

	'cart'			=> 'Sepet',
	'order'			=> 'Sipariş',

	'error'			=> 'Hata',
	'success'		=> 'Başarılı',
	'warning'		=> 'Uyarı',
	'info'			=> 'Bilgi',


	'pleasecheckerror'=> 'Lütfen aşağıdaki hataları kontrol ediniz;',
	'select'		=> 'Seçiniz',
	'goback'		=> 'Geri Dön',
	'iaccept'		=> 'Onaylıyorum',
	'anerroroccurred'=> 'Bir Hata Oluştu!',
	'notfoundtitle'	=> '404 Sayfa Bulunamadı - La Tienda Turca',
	'pagenotfound'	=> 'Aradığınız Sayfa Bulunamadı.',

	'loginfb'		=> 'Facebook ile Bağlan',
	'logintwitter'	=> 'Twitter ile Bağlan',


	'namesurname'	=> 'Adı Soyadı',
	'country'		=> 'Ülke',
	'nextstep'		=> 'Sonraki Adım',
	'addnew'		=> 'Yeni Oluşturun',
	'aboutthispage'	=> 'Bu Sayfa Hakkında',
	'cancellong'	=> 'İptal Et',
	'safelogout'	=> 'Güvenli Çıkış',


	'searchresults'	=> 'Arama Sonuçları',
	'word'			=> 'Kelime',
	'sort'			=> 'Sırala',
	'newest'		=> 'En Yeniler',
	'lowestprice'	=> 'En Düşük Fiyat',
	'highestprice'	=> 'En Yüksek Fiyat',
	'appearance'	=> 'Görünüm',
	'noresultfound'	=> 'Sonuç Bulunmamaktadır.',
	'guest'			=> 'Misafir',
	'applyfilter'	=> 'Filtrele',
	'filteroptions'	=> 'Filtre Seçenekleri',
	'errorandtry'	=> 'Bir hata oluştu. Lütfen tekrar deneyiniz.',
	'errortrylater'	=> 'Bir hata oluşmuştur. Lütfen daha sonra tekrar deneyiniz.',
	'congrats'		=> 'Tebrikler'
);
*/
