<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_id', 'body'
    ];

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
