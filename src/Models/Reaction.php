<?php

namespace Firefly\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function scopeGrouped(Builder $builder)
    {
        $builder->groupBy('reaction')
            ->select([
                'reaction',
                DB::raw('count(id) as count'),
            ]);
    }
}
