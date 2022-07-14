<?php

use Firefly\Models\Discussion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterPostsAddIsCorrect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_initial_post')->default(0)->after('content');
            $table->boolean('is_correct')->default(0)->after('is_initial_post');
        });

        Discussion::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('posts')
                ->whereRaw('discussion_id = discussions.id')
                ->where('is_initial_post', 1);
        })
            ->select(['id'])
            ->each(function ($discussion) {
                $firstPost = $discussion->posts()->orderBy('created_at')->first();

                $firstPost->update(['is_initial_post' => 1]);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['is_correct', 'is_initial_post']);
        });
    }
}
