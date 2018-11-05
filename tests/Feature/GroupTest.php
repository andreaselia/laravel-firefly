<?php

namespace Firefly\Test\Feature;

use Firefly\Test\Fixtures\Group;
use Firefly\Test\TestCase;

class GroupTest extends TestCase
{
    public function test_group_was_created()
    {
        // Clear all previous groups
        Group::truncate();

        $crawler = $this->actingAs($this->getUser())
            ->postJson('forum/groups', [
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

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $group->slug);
    }

    public function test_group_was_updated()
    {
        $group = $this->getGroup();

        $crawler = $this->actingAs($this->getUser())
            ->put('forum/groups/' . $group->slug, [
                'name' => 'Bar Foo',
                'color' => '#444',
            ]);

        $group->refresh();

        $this->assertEquals('Bar Foo', $group->name);
        $this->assertEquals('bar-foo', $group->slug);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $group->slug);
    }

    public function test_group_was_soft_deleted()
    {
        $group = $this->getGroup();

        $crawler = $this->actingAs($this->getUser())
            ->delete('forum/groups/' . $group->slug);

        $group->refresh();

        $this->assertFalse($group->exists());
        $this->assertNotNull($group->deleted_at);

        $crawler->assertRedirect();
        $crawler->assertLocation('forum');
    }

    public function test_name_is_required()
    {
        $name = '';
        $validJson = [
            'errors' => [
                'name' => [
                    'The name field is required.',
                ]
            ]
        ];

        // Create
        $crawler = $this->actingAs($this->getUser())
            ->postJson('forum/groups', [
                'name' => $name,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('name');
        $crawler->assertJson($validJson);

        // Update
        $group = $this->getGroup();

        $crawler = $this->actingAs($this->getUser())
            ->putJson('forum/groups/' . $group->slug, [
                'name' => $name,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('name');
        $crawler->assertJson($validJson);
    }

    public function test_name_has_a_max_of_255_characters()
    {
        $name = str_random(256);
        $validJson = [
            'errors' => [
                'name' => [
                    'The name may not be greater than 255 characters.',
                ]
            ]
        ];

        // Create
        $crawler = $this->actingAs($this->getUser())
            ->postJson('forum/groups', [
                'name' => $name,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('name');
        $crawler->assertJson($validJson);

        // Update
        $group = $this->getGroup();

        $crawler = $this->actingAs($this->getUser())
            ->putJson('forum/groups/' . $group->slug, [
                'name' => $name,
            ]);

        $crawler->assertStatus(422);
        $crawler->assertJsonValidationErrors('name');
        $crawler->assertJson($validJson);
    }
}
