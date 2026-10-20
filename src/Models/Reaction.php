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

            $reaction->reaction = static::decode($reaction->reaction);

            return $reaction;
        })->toArray());
    }

    /**
     * Encode non-ASCII characters as HTML entities, matching the output of the
     * deprecated mb_convert_encoding($reaction, 'HTML-ENTITIES', 'UTF-8').
     */
    public static function encode(string $reaction): string
    {
        $entities = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES | ENT_HTML401, 'UTF-8');

        return preg_replace_callback('/[^\x00-\x7F]/u', function ($match) use ($entities) {
            return $entities[$match[0]] ?? '&#'.mb_ord($match[0], 'UTF-8').';';
        }, $reaction);
    }

    /**
     * Decode a reaction encoded with encode().
     */
    public static function decode(string $reaction): string
    {
        return html_entity_decode($reaction, ENT_QUOTES | ENT_HTML401, 'UTF-8');
    }
}
