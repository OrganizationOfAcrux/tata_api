<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Library;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'class',
        'available',

    ];

    public function setSubjectAttribute($value)
    {
        $this->attributes['subject'] = ucfirst($value);// if u want to capital the full word and save it in the database use (strtoupper)
    }

    public function library()
    {
        return $this->belongsTo(Library::class);
    }
}
