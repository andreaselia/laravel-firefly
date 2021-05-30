<?php

namespace Firefly\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Auth\User;
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
        'is_private',
        'reply_count',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getIsPrivateAttribute()
    {
        if (! config('firefly.private_groups')) {
            return false;
        }

        return $this->groups->contains('is_private', true);
    }

    public function getReplyCountAttribute()
    {
        $replyCount = $this->posts->count();

        return $replyCount > 1 ? $replyCount - 1 : $replyCount;
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

    public function watchers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeWithIsBeingWatched(Builder $builder, $user)
    {
        $builder->when(config('firefly.features.watchers') && $user, function ($query) use ($user) {
            $query->leftJoin('discussion_user', function (JoinClause $join) use ($user) {
                $join->on('discussion_user.discussion_id', '=', 'discussions.id')
                    ->where('discussion_user.user_id', $user->id);
            })->select([
                'discussions.*',
                'discussion_user.user_id as is_being_watched',
            ]);
        });
    }
}
