<?php

namespace Firefly\Test\Feature\Api;

use Firefly\Test\Fixtures\Group;
use Firefly\Test\TestCase;

class GroupTest extends TestCase
{
    public function test_group_was_created()
    {
        // Clear all previous groups
        Group::truncate();

        $response = $this->actingAs($this->getUser(), 'api')
            ->postJson('api/forum/g', [
                'name' => 'Foo Bar',
                'color' => '#444',
            ]);

        $groups = Group::all();

        $this->assertTrue($groups->count() == 1);
        $this->assertDatabaseHas('groups', [
            'name' => 'Foo Bar',
            'color' => '#444',
        ]);

        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function test_groups_were_listed()
    {
        $response = $this->actingAs($this->getUser(), 'api')
            ->getJson('api/forum/g');

        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function test_group_was_listed()
    {
        $group = $this->getGroup();

        $response = $this->actingAs($this->getUser(), 'api')
            ->getJson('api/forum/g/'.$group->slug);

        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function test_group_was_updated()
    {
        $group = $this->getGroup();

        $response = $this->actingAs($this->getUser(), 'api')
            ->putJson('api/forum/g/'.$group->slug, [
                'name' => 'Bar Foo',
                'color' => '#444',
            ]);

        $group->refresh();

        $this->assertEquals('Bar Foo', $group->name);
        $this->assertEquals('bar-foo', $group->slug);

        $response->assertOk();
        $response->assertJsonStructure();
    }

    public function test_group_was_soft_deleted()
    {
        $group = $this->getGroup();

        $response = $this->actingAs($this->getUser(), 'api')
            ->deleteJson('api/forum/g/'.$group->slug);

        $group->refresh();

        $this->assertFalse($group->exists());
        $this->assertNotNull($group->deleted_at);

        $response->assertOk();
    }
}
