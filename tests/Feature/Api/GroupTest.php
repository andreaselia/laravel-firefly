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

    public function test_group_was_updated()
    {
        $group = $this->getGroup();

        $crawler = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/groups/' . $group->slug, [
                'name' => 'Bar Foo',
                'color' => '#444',
            ]);

        $group->refresh();

        $this->assertEquals('Bar Foo', $group->name);
        $this->assertEquals('bar-foo', $group->slug);

        $crawler->assertOk();
        $crawler->assertJsonStructure();
    }

    public function test_group_was_soft_deleted()
    {
        $group = $this->getGroup();

        $crawler = $this->actingAs($this->getUser(), 'api')
            ->deleteJson('api/forum/groups/' . $group->slug);
        
        $group->refresh();

        $this->assertFalse($group->exists());
        $this->assertNotNull($group->deleted_at);

        $crawler->assertOk();
    }
}
