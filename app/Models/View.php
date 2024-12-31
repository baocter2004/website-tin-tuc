<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $fillable = [
        "article_id",
        "viewed_at",
        "user_id",
        "ip_address",
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function article()
    {
        return $this->belongsTo(Article::class);  // Một lượt xem thuộc về một bài viết
    }
}
