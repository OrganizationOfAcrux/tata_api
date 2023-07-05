<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\Library;

use Illuminate\Database\Eloquent\Model;

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
        'role_id',
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

    //these two function save the first_name and last_name first word in capital
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);// if u want to capital the full word and save it in the database use (strtoupper)
    }


    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }

    // these two function save the username and email in small letters
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

    public function library()
    {
        return $this->hasMany(Library::class);
    }

    //this is for to get teh role name and show in fronend
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
