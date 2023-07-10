<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Book;

class Library extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['user_id', 'book_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }


    protected $appends = ['student_name', 'book_name', 'class_name'];

    public function getStudentNameAttribute()
    {
        $st = $this->user()->first();
        if (isset($st)) {
            return $st->first_name .  " " .  $st->last_name;
        } else {
            return null;
        }
    }


    public function getBookNameAttribute()
    {
        $book = $this->book()->first();
        if (isset($book)) {
            return $book->subject;
        } else {
            return null;
        }
    }

    public function getClassNameAttribute()
    {
        $book = $this->book()->first();
        if (isset($book)) {
            return $book->class;
        } else {
            return null;
        }
    }

}
