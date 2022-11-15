<?php

namespace Firefly\Test\Feature;

use Firefly\Models\Reaction;
use Firefly\Test\TestCase;

class ReactionTest extends TestCase
{
    public function test_reaction_was_created()
    {
        $this->actingAs($this->getUser());

        $this->assertEquals(0, Reaction::count());
        $this->assertEquals(0, $this->getPost()->reactions()->count());

        $response = $this->post('/forum/p/'.$this->getPost()->id.'/reactions', [
            'reaction' => '😀',
        ]);

        $this->assertEquals(1, Reaction::count());
        $this->assertEquals(1, $this->getPost()->reactions()->count());

        $reactions = $this->getPost()->groupedReactions()->toArray();
        $response->assertJson($reactions);
    }

    public function test_reaction_was_deleted_when_sending_the_same_reaction()
    {
        $this->actingAs($this->getUser());

        $reaction = new Reaction([
            'user_id'  => $this->getUser()->id,
            'reaction' => '😀',
        ]);

        $this->getPost()->reactions()->save($reaction);

        $this->assertEquals(1, Reaction::count());
        $this->assertEquals(1, $this->getPost()->reactions()->count());

        $response = $this->post('/forum/p/'.$this->getPost()->id.'/reactions', [
            'reaction' => '😀',
        ]);

        $this->assertEquals(0, Reaction::count());
        $this->assertEquals(0, $this->getPost()->reactions()->count());

        $response->assertJson([]);
    }

    public function test_reaction_was_deleted()
    {
        $this->actingAs($this->getUser());

        $reaction = $this->getPost()->reactions()->save(new Reaction([
            'user_id'  => $this->getUser()->id,
            'reaction' => '😀',
        ]));

        $this->assertEquals(1, Reaction::count());
        $this->assertEquals(1, $this->getPost()->reactions()->count());

        $response = $this->delete('/forum/p/'.$this->getPost()->id.'/reactions/'.$reaction->id);

        $this->assertEquals(0, Reaction::count());
        $this->assertEquals(0, $this->getPost()->reactions()->count());

        $response->assertJson([]);
    }
}
