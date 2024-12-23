<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paragraph extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'paragraph',
        'order',
        'article_id'
    ];

    public function article() {
        return $this->belongsTo(Article::class);
    }
    public function mediums() {
        return $this->hasMany(Media::class);
    }
}
