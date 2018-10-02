<?php

namespace Firefly;

trait Hideable
{
    /**
     * Hide the current model.
     *
     * @return $this
     */
    public function hide()
    {
        $this->update([
            'hidden_at' => now(),
        ]);

        return $this;
    }

    /**
     * Unhide the current model.
     *
     * @return $this
     */
    public function unhide()
    {
        $this->update([
            'hidden_at' => null,
        ]);

        return $this;
    }
}