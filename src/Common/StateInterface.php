<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace PhpUnified\State\Common;

/**
 * An interface to keep track of the state of anything within the application.
 */
interface StateInterface
{
    /**
     * Converts the state to a human readable string.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Sets the value of the state.
     *
     * @param string $value The value of the state.
     *
     * @return void
     */
    public function setValue(string $value): void;

    /**
     * Retrieves the value of the state.
     *
     * @return string
     */
    public function getValue(): string;

    /**
     * Sets the identifier of the state.
     *
     * @param string $identifier The identifier of the state.
     *
     * @return void
     */
    public function setIdentifier(string $identifier): void;

    /**
     * Retrieves the identifier of the state.
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Converts the state to an array.
     *
     * @return array
     */
    public function exportState(): array;

    /**
     * Adds a state to the state.
     *
     * @param StateInterface $state The state that should be a sub-state of this state.
     */
    public function addState(StateInterface $state): void;
}
