<?php

namespace Firefly\Test\Unit;

use Firefly\Test\TestCase;

class FireflyUserTest extends TestCase
{
    public function test_can_get_watching()
    {
        $discussion = $this->getDiscussion();

        $user = $this->getUser();
        $discussion->watchers()->save($user);

        $discussion->refresh();
        $user->refresh();

        $this->assertEquals(1, $discussion->watchers()->count());

        $this->assertEquals(1, $user->watching()->count());
        $this->assertEquals($discussion->id, $user->watching->first()->id);
    }

    public function test_can_get_is_watching()
    {
        $discussion = $this->getDiscussion();

        $user = $this->getUser();
        $this->assertFalse($user->isWatching($discussion));

        $discussion->watchers()->save($user);

        $user->refresh();
        $this->assertEquals(1, $user->watching()->count());

        $this->assertTrue($user->isWatching($discussion));
    }
}
