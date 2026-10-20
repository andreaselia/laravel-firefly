<?php

namespace Firefly\Test\Unit;

use Firefly\Models\Reaction;
use Firefly\Test\TestCase;

class ReactionTest extends TestCase
{
    public function test_encode_matches_previously_stored_reactions()
    {
        $this->assertEquals('&#128512;', Reaction::encode('😀'));
        $this->assertEquals('&#10084;&#65039;', Reaction::encode('❤️'));
        $this->assertEquals('&#128104;&zwj;&#128105;&zwj;&#128103;', Reaction::encode('👨‍👩‍👧'));
        $this->assertEquals('&eacute; <&>', Reaction::encode('é <&>'));
    }

    public function test_decode_reverses_encode()
    {
        foreach (['😀', '❤️', '👨‍👩‍👧', '🏳️‍🌈', 'é <&>'] as $reaction) {
            $this->assertEquals($reaction, Reaction::decode(Reaction::encode($reaction)));
        }
    }
}
