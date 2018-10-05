<?php

namespace Firefly;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Discussion extends Model
{
    use HasSlug, Hideable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'locked_at', 'stickied_at', 'hidden_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'locked_at', 'stickied_at', 'hidden_at', 'deleted_at',
    ];

    /**
     * Get the options for generating the slug.
     *
     * @return \Spatie\Sluggable\SlugOptions
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Return the user that created the discussion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('firefly.user'))->withDefault([
            'name' => 'Unknown Author',
        ]);
    }

    /**
     * Alias for the 'user' method.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->user();
    }

    /**
     * Get all of the groups this discussion belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * Get all the posts for the discussion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the URI for the discussion.
     *
     * @return string
     */
    public function getUriAttribute()
    {
        return "{$this->id}-{$this->slug}";
    }

    /**
     * Lock the discussion.
     *
     * @return $this
     */
    public function lock()
    {
        $this->update([
            'locked_at' => now(),
        ]);

        return $this;
    }

    /**
     * Unlock the discussion.
     *
     * @return $this
     */
    public function unlock()
    {
        $this->update([
            'locked_at' => null,
        ]);

        return $this;
    }

    /**
     * Stick the discussion.
     *
     * @return $this
     */
    public function stick()
    {
        $this->update([
            'stickied_at' => now(),
        ]);

        return $this;
    }

    /**
     * Unstick the discussion.
     *
     * @return $this
     */
    public function unstick()
    {
        $this->update([
            'stickied_at' => null,
        ]);

        return $this;
    }
}
