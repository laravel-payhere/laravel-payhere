<?php

namespace Workbench\App\Models;

use LaravelPayHere\Billable;
use LaravelPayHere\Models\Contracts\PayHereCustomer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Workbench\Database\Factories\UserFactory;

class User extends Authenticatable implements PayHereCustomer
{
    use Billable;
    use HasFactory;
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
        'phone',
        'address',
        'city',
        'country',
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

    public function payHerePhone(): ?string
    {
        return null;
    }

    public function payHereAddress(): ?string
    {
        return null;
    }

    public function payHereCity(): ?string
    {
        return null;
    }

    public function payHereCountry(): ?string
    {
        return null;
    }

    protected static function newFactory(): UserFactory
    {
        return new UserFactory;
    }
}