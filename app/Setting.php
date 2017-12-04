<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = ['isim', 'resmi_isim', 'web', 'tel', 'tel2', 'faks', 'email', 'sip_email', 'adres', 'sicil_no', 'vergi_no', 'vergi_d', 'meta_baslik', 'meta_aciklama', 'meta_keywords', 'logo', 'favicon', 'site_durum', 'google_meta', 'google_analytics', 'theme','facebook_login','twitter_login','para_birim', 'facebook_clid','facebook_clsecret','twitter_clid','twitter_clsecret', 'dinamik_stok', 'def_uzunluk', 'def_agirlik','catalog','featured_count','logo_type','logo_text','logo_color','logo_fontsize','logo_font'];

    public function themes() {
        return $this->hasOne('Sitetheme');
    }
}
