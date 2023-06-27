<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
