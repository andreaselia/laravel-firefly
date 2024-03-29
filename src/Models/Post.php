<?php

namespace Firefly\Models;

use Firefly\Features;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

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
        return $this
            ->belongsTo(config('firefly.user'))
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
        return $this->isRichlyFormatted
            ? $this->content
            : nl2br(e($this->content));
    }

    public function getIsRichlyFormattedAttribute(): bool
    {
        return $this->formatting === 'rich';
    }

    public function getIsCorrectAttribute()
    {
        return ! is_null($this->corrected_at);
    }

    public function scopeWithSearch(Builder $builder, ?string $search)
    {
        $search = strtr($search, ['%' => '\%', '_' => '\_', '\\' => '\\\\']);

        $builder->when(Features::enabled('search') && $search, function ($query) use ($search) {
            $query->where('content', 'like', '%'.$search.'%');
        });
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function groupedReactions(): Collection
    {
        return $this
            ->hasMany(Reaction::class)
            ->with('user')
            ->get()
            ->groupBy('reaction')
            ->map(function ($reactionGroup, $reaction) {
                $users = $reactionGroup
                    ->sortByDesc(fn ($reactionGroup) => $reactionGroup->user->id == auth()->id() ? 1 : 0)
                    ->map(fn ($reactionGroup) => $reactionGroup->user->id == auth()->id() ? __('You') : $reactionGroup->user->{config('firefly.name')})
                    ->implode(', ');

                return [
                    'reaction' => $reaction,
                    'count'    => $reactionGroup->count(),
                    'users'    => $users,
                ];
            })
            ->values();
    }
}
