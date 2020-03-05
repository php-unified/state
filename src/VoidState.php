<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace PhpUnified\State;

use PhpUnified\State\Common\StateInterface;

/**
 * An implementation of a state which does nothing.
 */
class VoidState implements StateInterface
{
    /**
     * Converts the state to a human readable string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return '';
    }

    /**
     * Sets the value of the state.
     *
     * @param string $value The value of the state.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setValue(string $value): void
    {
        return;
    }

    /**
     * Retrieves the value of the state.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getValue(): string
    {
        return '';
    }

    /**
     * Sets the identifier of the state.
     *
     * @param string $identifier The identifier of the state.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setIdentifier(string $identifier): void
    {
        return;
    }

    /**
     * Retrieves the identifier of the state.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return '';
    }

    /**
     * Converts the state to an array.
     *
     * @return array
     */
    public function exportState(): array
    {
        return [];
    }

    /**
     * Adds a state to the state.
     *
     * @param StateInterface $state The state that should be a sub-state of this state.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function addState(StateInterface $state): void
    {
        return;
    }
}
