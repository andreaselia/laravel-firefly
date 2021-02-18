<?php

namespace Firefly\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Discussion extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    /** @var array */
    protected $fillable = [
        'title',
        'locked_at',
        'pinned_at',
    ];

    /** @var array */
    protected $dates = [
        'locked_at',
        'pinned_at',
        'deleted_at',
    ];

    /** @var array */
    protected $appended = [
        'post_count',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getPostCountAttribute(): string
    {
        $replyCount = $this->posts->count() - 1;
        $appendedText = $replyCount > 1 ? __('replies') : __('reply');

        return sprintf('%s %s', $replyCount, $appendedText);
    }

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

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getUriAttribute(): string
    {
        return sprintf(
            '%s-%s',
            $this->id, $this->slug
        );
    }

    public function lock()
    {
        $this->update([
            'locked_at' => now(),
        ]);

        return $this;
    }

    public function unlock()
    {
        $this->update([
            'locked_at' => null,
        ]);

        return $this;
    }

    public function pin()
    {
        $this->update([
            'pinned_at' => now(),
        ]);

        return $this;
    }

    public function unpin()
    {
        $this->update([
            'pinned_at' => null,
        ]);

        return $this;
    }

    public function getReplyCountAttribute(): string
    {
        $count = $this->posts->count() - 1;

        if ($count <= 0) {
            return '';
        }

        return sprintf(
            '%s %s',
            $count, Str::plural('reply', $count)
        );
    }
}
