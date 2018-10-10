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
            ->post('forum/groups', [
                'name' => 'Foo Bar',
            ]);

        $groups = Group::all();

        $this->assertTrue($groups->count() == 1);
        $this->assertDatabaseHas('groups', [
            'name' => 'Foo Bar',
            'slug' => 'foo-bar',
        ]);

        $group = Group::first();

        $crawler->assertRedirect();
        $crawler->assertLocation('forum/' . $group->uri);
    }
}
