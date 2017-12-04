<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bank_accounts';
    protected $fillable = ['bankaAdi', 'subeAdi', 'subeKodu', 'hesapAdi', 'hesapNo', 'hesapTuru', 'iban', 'status'];
}
