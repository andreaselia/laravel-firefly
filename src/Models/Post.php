<?php

namespace Firefly\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /** @var array */
    protected $fillable = [
        'content',
        'formatting',
        'is_initial_post',
        'corrected_at',
    ];

    /** @var array */
    protected $dates = [
        'deleted_at',
        'corrected_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('firefly.user'))
            ->withDefault([
                'name' => 'Unknown Author',
            ]);
    }

    public function author(): BelongsTo
    {
        return $this->user();
    }

    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    public function getFormattedContentAttribute(): string
    {
        return $this->isRichlyFormatted ? $this->content : nl2br(e($this->content));
    }

    public function getIsRichlyFormattedAttribute(): bool
    {
        return $this->formatting === 'rich';
    }

    public function getIsCorrectAttribute()
    {
        return ! is_null($this->corrected_at);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function groupedReactions()
    {
        return $this->hasMany(Reaction::class)
            ->grouped();
    }
}
