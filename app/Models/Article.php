<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "title",
        "image",
        "slug",
        "content",
        "summary",
        "auth_id",
        "category_id",
        "publish_at",
        "status",
        'delete_reason'
    ];
}
