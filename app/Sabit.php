<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sabit extends Model
{
    public static function itemStatus($id = null)
    {
        $durum = array(
            0 => 'Pasif',
            1 => 'Aktif'
        );

        return (!is_null($id)) ? $durum[$id] : $durum;
    }

    public static function stockStatus($id = null)
    {
        $durum = array(
            0 => 'Yok',
            1 => 'Var'
        );

        return (!is_null($id)) ? $durum[$id] : $durum;
    }

    public static function yesNo($id = null)
    {
        $durum = array(
            0 => 'Hayır',
            1 => 'Evet'
        );

        return (!is_null($id)) ? $durum[$id] : $durum;
    }

    public static function logoType($id = null)
    {
        $durum = array(
            0 => 'Görsel',
            1 => 'Yazı'
        );

        return (!is_null($id)) ? $durum[$id] : $durum;
    }

    public static function bankNames($id = null)
    {
        $durum = array(
            1 => 'Abn Ambro Bank',
            2 => 'Adabank',
            3 => 'Akbank',
            4 => 'Albarakatürk',
            5 => 'Alternatifbank',
            6 => 'Aktif',
            7 => 'Aktif',
            8 => 'Aktif',
            9 => 'Aktif',
            10 => 'Aktif',

        );

        return (!is_null($id)) ? $durum[$id] : $durum;
    }

    public static function getGender($id = null, $lang = 'tr')
    {
        if($lang == 'tr')
        {
            $gender = array(
                0 => 'Seçiniz',
                1 => 'Kadın',
                2 => 'Erkek',
                3 => 'Diğer',
            );
        }
        else {
            $gender = array(
                0 => 'Select',
                1 => 'Female',
                2 => 'Male',
                3 => 'Other',
            );
        }



        return (!is_null($id)) ? $gender[$id] : $gender;
    }

    public static function pageType($id = null)
    {
        $type = array(
            0 => '-',
            1 => 'Sayfa',
            2 => 'Haber',
        );

        return (!is_null($id)) ? $type[$id] : $type;
    }

    public static function addressType($id = null, $lang = 'tr')
    {
        if($lang == 'tr')
        {
            $type = array(
                1 => 'Teslimat',
                2 => 'Fatura',
            );
        }
        else {
            $type = array(
                1 => 'Delivery',
                2 => 'Invoice',
            );
        }
        return (!is_null($id)) ? $type[$id] : $type;
    }

    public static function faturaType($id = null, $lang = 'tr')
    {
        if($lang == 'tr')
        {
            $type = array(
                0 => '-',
                1 => 'Bireysel',
                2 => 'Kurumsal',
            );
        }
        else
        {
            $type = array(
                0 => '-',
                1 => 'Individual',
                2 => 'Institutional',
            );
        }



        return (!is_null($id)) ? $type[$id] : $type;
    }

    public static function creditCardType($id = null)
    {
        $type = array(
            1 => 'Visa',
            2 => 'MasterCard',
            3 => 'American Express',
        );
        return (!is_null($id)) ? $type[$id] : $type;
    }

    public static function getMonthsNumber($id = null)
    {
        $type = array(
            1 => '01',
            2 => '02',
            3 => '03',
            4 => '04',
            5 => '05',
            6 => '06',
            7 => '07',
            8 => '08',
            9 => '09',
            10 => '10',
            11 => '11',
            12 => '12'
        );
        return (!is_null($id)) ? $type[$id] : $type;
    }

    public static function paraBirimi($id = null)
    {
        $type = array(
            "QAR" => 'QAR',
            "₺" => 'TL',
            "$" => 'USD',
            "€" => 'EUR',
        );
        return (!is_null($id)) ? $type[$id] : $type;
    }

    public static function dimensionLength($id = null)
    {
        $type = array(
            'm' => 'm',
            'dm' => 'dm',
            'cm' => 'cm',
            'mm' => 'mm',
            'mu' => 'mu',
            'Dm' => 'Dm',
            'hm' => 'hm',
            'Km' => 'Km'
        );
        return (!is_null($id)) ? $type[$id] : $type;
    }

    public static function weightLength($id = null)
    {
        $type = array(
            'kg' => 'kg',
            'gr' => 'gr',
            'dg' => 'dg',
            'sg' => 'sg',
            'mg' => 'mg',
            'K' => 'K',
            'Ton' => 'Ton',
            'Kiloton' => 'Kiloton'
        );
        return (!is_null($id)) ? $type[$id] : $type;
    }
}

