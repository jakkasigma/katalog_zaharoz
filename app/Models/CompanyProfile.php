<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'whatsapp',
        'address',
        'city',
        'province',
        'postal_code',
        'description',
        'instagram_url',
        'tiktok_url',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'qris_path',
    ];
}
