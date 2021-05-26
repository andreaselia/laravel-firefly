<?php

namespace Firefly\Test\Feature;

use Firefly\Test\Fixtures\Group;
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
}
