<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_id', 'category_id'
    ];
}
