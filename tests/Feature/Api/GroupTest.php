<?php

namespace Firefly\Test\Feature\Api;

use Firefly\Test\TestCase;
use Firefly\Test\Fixtures\Group;

class GroupTest extends TestCase
{
    public function test_group_was_created()
    {
        // Clear all previous groups
        Group::truncate();

        $crawler = $this->actingAs($this->getUser(), 'api')
            ->postJson('api/forum/groups', [
                'name' => 'Foo Bar',
                'color' => '#444',
            ]);

        $groups = Group::all();

        $this->assertTrue($groups->count() == 1);
        $this->assertDatabaseHas('groups', [
            'name' => 'Foo Bar',
            'color' => '#444',
        ]);

        $crawler->assertOk();
        $crawler->assertJsonStructure();
    }
}
