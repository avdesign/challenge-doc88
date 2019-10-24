<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','code','email','phone','address','complement','district','zipcode','birth_date','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Create
     *
     * @param array $attriibutes
     * @return mixed
     */
    public static function createCustomer($attriibutes = array())
    {
        $code = uniqid(date('YmdHis'));
        $attriibutes['code'] = returnNumber($code);

        !isset($attriibutes['email'])?:$attriibutes['email'] = strtolower($attriibutes['email']);
        !isset($attriibutes['password'])?:$attriibutes['password'] = bcrypt($attriibutes['password']);

        return parent::create($attriibutes);
    }
}
