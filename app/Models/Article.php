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
        "view_count",
        "content",
        "summary",
        "auth_id",
        "category_id",
        "publish_at",
        "status",
        'delete_reason'
    ];
    const STATUSES = [
        'draft',
        'published',
        'approved',
        'deleted',
    ];

    public $attributes = [
        'status' => self::STATUSES[0]
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'auth_id');
    }

    public function paragraphs()
    {
        return $this->hasMany(Paragraph::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
