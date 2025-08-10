<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; //ダミーデータ用

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'format',
        'status',
        'isbn',
        'notes',
        'finished_at',
        'cover_path',
        'is_public',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
