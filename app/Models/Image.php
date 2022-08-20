<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'path', 'imagable_type', 'imagable_id', 'size', 'extension'
      ];

      public function issue()
      {
          return $this->belongsTo(Issue::class);
      }

      public function comment()
      {
          return $this->belongsTo(Comment::class);
      }

}
