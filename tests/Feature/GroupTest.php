<?php

namespace Firefly\Test\Feature;

use Firefly\Test\Fixtures\Discussion;
use Firefly\Test\Fixtures\Group;
use Firefly\Test\Fixtures\Post;
use Firefly\Test\TestCase;
use Illuminate\Support\Str;

class GroupTest extends TestCase
{
    public function test_group_was_created()
    {
        // Clear all previous groups
        Group::truncate();

        $response = $this->actingAs($this->getUser())
            ->postJson('forum/g', [
                'name' => 'Foo Bar',
                'color' => '#444',
            ]);

        $groups = Group::all();

        $this->assertTrue($groups->count() == 1);
        $this->assertDatabaseHas('groups', [
            'name' => 'Foo Bar',
            'slug' => 'foo-bar',
        ]);

        $group = Group::first();

        $response->assertRedirect();
        $response->assertLocation('forum/g/'.$group->slug);
    }

    public function test_group_was_updated()
    {
        $group = $this->getGroup();

        $response = $this->actingAs($this->getUser())
            ->put('forum/g/'.$group->slug, [
                'name' => 'Bar Foo',
                'color' => '#444',
            ]);

        $group->refresh();

        $this->assertEquals('Bar Foo', $group->name);
        $this->assertEquals('bar-foo', $group->slug);

        $response->assertRedirect();
        $response->assertLocation('forum/g/'.$group->slug);
    }

    public function test_group_was_soft_deleted()
    {
        $group = $this->getGroup();

        $response = $this->actingAs($this->getUser())
            ->delete('forum/g/'.$group->slug);

        $group->refresh();

        $this->assertFalse($group->exists());
        $this->assertNotNull($group->deleted_at);

        $response->assertRedirect();
        $response->assertLocation('forum');
    }

    public function test_name_is_required()
    {
        $name = '';
        $validJson = [
            'errors' => [
                'name' => [
                    'The name field is required.',
                ],
            ],
        ];

        // Create
        $response = $this->actingAs($this->getUser())
            ->postJson('forum/g', [
                'name' => $name,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
        $response->assertJson($validJson);

        // Update
        $group = $this->getGroup();

        $response = $this->actingAs($this->getUser())
            ->putJson('forum/g/'.$group->slug, [
                'name' => $name,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
        $response->assertJson($validJson);
    }

    public function test_name_has_a_max_of_255_characters()
    {
        $name = Str::random(256);
        $validJson = [
            'errors' => [
                'name' => [
                    'The name must not be greater than 255 characters.',
                ],
            ],
        ];

        // Create
        $response = $this->actingAs($this->getUser())
            ->postJson('forum/g', [
                'name' => $name,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
        $response->assertJson($validJson);

        // Update
        $group = $this->getGroup();

        $response = $this->actingAs($this->getUser())
            ->putJson('forum/g/'.$group->slug, [
                'name' => $name,
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
        $response->assertJson($validJson);
    }

    public function test_can_get_discussion_list_with_search()
    {
        $this->enableFeature('search');

        Post::truncate();
        Discussion::truncate();

        $group = $this->getGroup();

        $discussion = Discussion::create([
            'user_id'  => $this->getUser()->id,
            'title'    => 'I want to search for content',
        ]);

        $group->discussions()->save($discussion);

        Post::create([
            'discussion_id' => $discussion->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Does Not Match',
        ]);

        $discussionTwo = Discussion::create([
            'user_id'  => $this->getUser()->id,
            'title'    => 'I do not like finding content',
        ]);

        $group->discussions()->save($discussionTwo);

        Post::create([
            'discussion_id' => $discussionTwo->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Does Not Match',
        ]);

        $discussionThree = Discussion::create([
            'user_id'  => $this->getUser()->id,
            'title'    => 'I like finding content in posts',
        ]);

        $group->discussions()->save($discussionThree);

        Post::create([
            'discussion_id' => $discussionThree->id,
            'user_id'       => $this->getUser()->id,
            'content'       => 'Should search for a match',
        ]);

        $this->assertEquals(3, Discussion::count());
        $this->assertEquals(3, $this->getGroup()->discussions->count());

        $response = $this->actingAs($this->getUser())
            ->get('forum/g/'.$group->slug.'?search=search');

        $discussions = $response->viewData('discussions');

        $this->assertEquals(2, $discussions->count());

        $this->assertEquals($discussion->id, $discussions->first()->id);
        $this->assertEquals($discussionThree->id, $discussions->skip(1)->first()->id);
    }
}
