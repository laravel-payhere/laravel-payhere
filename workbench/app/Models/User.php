<?php

namespace Workbench\App\Models;

use Dasundev\PayHere\Billable;
use Dasundev\PayHere\Models\Contracts\PayHereCustomer;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements PayHereCustomer
{
    use Billable;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function payHereFirstName(): string
    {
        return explode(' ', trim($this->name))[0];
    }

    public function payHereLastName(): string
    {
        return explode(' ', trim($this->name))[1];
    }

    public function payHereEmail(): string
    {
        return $this->email;
    }

    public function payHerePhone(): string
    {
        return $this->phone;
    }

    public function payHereAddress(): string
    {
        return $this->address;
    }

    public function payHereCity(): string
    {
        return $this->city;
    }

    public function payHereCountry(): string
    {
        return $this->country;
    }
}
