<?php

namespace Firefly\Test\Feature\Api;

use Firefly\Models\Reaction;
use Firefly\Test\TestCase;

class ReactionTest extends TestCase
{
    public function test_reaction_was_created()
    {
        $this->assertEquals(0, Reaction::count());
        $this->assertEquals(0, $this->getPost()->reactions()->count());

        $response = $this->actingAs($this->getUser(), 'api')
            ->postJson('api/forum/p/'.$this->getPost()->id.'/react', [
                'reaction' => '😀',
            ]);

        $this->assertEquals(1, Reaction::count());
        $this->assertEquals(1, $this->getPost()->reactions()->count());

        $reactions = $this->getPost()->reactions->toArray();

        $response->assertStatus(200);
        $response->assertJson($reactions);
    }

    public function test_reaction_was_deleted_when_sending_the_same_reaction()
    {
        $reaction = new Reaction([
            'user_id'  => $this->getUser()->id,
            'reaction' => '😀',
        ]);

        $this->getPost()->reactions()->save($reaction);

        $this->assertEquals(1, Reaction::count());
        $this->assertEquals(1, $this->getPost()->reactions()->count());

        $response = $this->actingAs($this->getUser(), 'api')
            ->post('api/forum/p/'.$this->getPost()->id.'/react', [
                'reaction' => '😀',
            ]);

        $this->assertEquals(0, Reaction::count());
        $this->assertEquals(0, $this->getPost()->reactions()->count());

        $response->assertJson([]);
    }

    public function test_reaction_was_deleted()
    {
        $reaction = $this->getPost()->reactions()->save(new Reaction([
            'user_id'  => $this->getUser()->id,
            'reaction' => '😀',
        ]));

        $this->assertEquals(1, Reaction::count());
        $this->assertEquals(1, $this->getPost()->reactions()->count());

        $response = $this->actingAs($this->getUser(), 'api')
            ->delete('api/forum/p/'.$this->getPost()->id.'/reaction/'.$reaction->id);

        $this->assertEquals(0, Reaction::count());
        $this->assertEquals(0, $this->getPost()->reactions()->count());

        $response->assertJson([]);
    }
}
