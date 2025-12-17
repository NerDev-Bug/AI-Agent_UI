<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User_Account extends Model
{
    use HasFactory;
    protected $table = 'user_account';

    protected $fillable = [
        'username',
        'user_email',
        'cooperative_company',
        'contact_number',
        'password',
        'role',
    ];

    protected $hidden = ['password', 'remember_token', 'verification_token', 'email_verified_at'];
}
