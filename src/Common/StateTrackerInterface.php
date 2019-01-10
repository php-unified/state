<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace PhpUnified\State\Common;

/**
 * An interface to indicate that the implementation can optionally track a state.
 */
interface StateTrackerInterface
{
    /**
     * Adds a state to the implementation which tracks a state.
     *
     * @param StateInterface $state The state that should be tracked by this implementation.
     */
    public function addState(StateInterface $state): void;
}
