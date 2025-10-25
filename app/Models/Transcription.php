<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transcription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'language',
        'status',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    protected $attributes = [
        'status' => 'draft',
        'language' => 'en',
        'metadata' => '{}',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
