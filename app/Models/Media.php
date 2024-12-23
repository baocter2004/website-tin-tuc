<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'paragraph_id',
        'file_path',
    ];

    public function paragraph() {
        return $this->belongsTo(Paragraph::class);
    }
}
