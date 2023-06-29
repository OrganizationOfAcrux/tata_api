<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone_number',
        'password',
        'reset_token',
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


    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);// if u want to capital the full word and save it in the database use (strtoupper)
    }


    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }


    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }


    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    //making the connection for the role table
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    protected $appends = ['role_name'];

    public function getRoleNameAttribute()
    {
        $role = $this->role()->first();
        if (isset($role)) {
            return $role->name;
        } else {
            return null;
        }
    }
}
