<?php

namespace AndreasElia\Firefly\Test;

class FireflyFunctionTest extends TestCase
{
    /**
     * @return void
     */
    public function test_true_is_true()
    {
        $this->assertTrue(true);
    }

    /**
     * @return void
     */
    public function test_false_is_false()
    {
        $this->assertFalse(false);
    }
}
