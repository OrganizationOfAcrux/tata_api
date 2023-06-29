<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discription',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);// if u want to capital the full word and save it in the database use (strtoupper)
    }


    // making the connection for the user
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
