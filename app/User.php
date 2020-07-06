<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends \Konekt\AppShell\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'is_verified',
        'rut',
        'birthday',
        'address1',
        'address2',
        'city',
        'state',
        'countryid',
        'username'
    ];

    public static $rules = [
        'rut' => 'required|unique:users|cl_rut|max:9',
        'name' => 'required|alpha',
        'telephone' => 'required|alpha',
        'birthdate' => 'required|date',
        'address1' => 'required|alpha',
        'address2' => 'alpha',
        'city' => 'required|alpha',
        'state' => 'required|alpha',
        'countryid' => 'required|alpha',
        'email' => 'required|unique:users|email',
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

    public function cuentas()
    {
        return $this->hasMany('App\Cuenta');
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->telephone;
    }

    public function addresses()
    {
        return $this->hasMany('App\UserAddress');
    }

    public function notificaciones()
    {
        return $this->hasMany('App\Notificacion');
    }

    public function identificacion()
    {
        return $this->hasMany('App\Identificacion');
    }

    public function getCountryAttribute()
    {
        $country = Country::where('id', $this->countryid)->first();

        return $country;
    }

    public function cuenta_bancaria()
    {
        return $this->hasMany('App\CuentaBancaria');
    }

    public function getFormattedRutAttribute()
    {
        return \Freshwork\ChileanBundle\Rut::parse($this->rut)->format();
    }

    public function sponsor()
    {
        return $this->hasOne('App\User', 'sponsor_id');
    }

    public function binaryParent()
    {
        return $this->hasOne('App\User', 'binary_parent_id');
    }

    public function getBinarySideAttribute($binary_side)
    {
        switch($binary_side){
            case 0:
                return 'izquierda';
            break;
            case 1:
                return 'derecha';
            break;
        }
    }

    public function binaryChildren()
    {
        return $this->hasMany(User::class, 'binary_parent_id');
    }

    public function binaryDescendants()
    {
        return $this->hasMany(User::class, 'binary_parent_id')->with('binaryChildren');
    }

    public function sponsorChildren()
    {
        return $this->hasMany(User::class, 'sponsor_id');
    }

    public function sponsorDescendants()
    {
        return $this->hasMany(User::class, 'sponsor_id')->with('sponsorChildren');
    }

}
