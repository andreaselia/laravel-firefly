<?php

namespace Firefly\Models;

use Firefly\Features;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Reaction extends Model
{
    use HasFactory;

    /** @var array */
    protected $fillable = [
        'post_id',
        'user_id',
        'reaction',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('firefly.user'));
    }

    public function scopeGrouped(Builder $builder)
    {
        $builder
            ->groupBy('reaction')
            ->select([
                'reaction',
                DB::raw('count(id) as count'),
            ]);
    }

    public static function convertReactions($reactions): string
    {
        if (! Features::option('reactions', 'convert')) {
            return json_encode($reactions);
        }

        return json_encode(collect($reactions)->map(function ($reaction) {
            if (is_array($reaction)) {
                $reaction = (object) $reaction;
            }

            $reaction->reaction = mb_convert_encoding($reaction->reaction, 'UTF-8', 'HTML-ENTITIES');

            return $reaction;
        })->toArray());
    }
}
