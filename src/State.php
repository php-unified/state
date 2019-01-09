<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace PhpUnified\State;

use PhpUnified\State\Common\StateInterface;

/**
 * A simple implementation of a state.
 */
class State implements StateInterface
{
    /**
     * The indentation used for the implementation.
     *
     * @var string
     */
    const INDENTATION = '  ';

    /**
     * The linebreak character used to separate states.
     *
     * @var string
     */
    const LINEBREAK = PHP_EOL;

    /**
     * The value of the state.
     *
     * @var string
     */
    private $value;

    /**
     * The identifier of the state.
     *
     * @var string
     */
    private $identifier;

    /**
     * The states added to this state.
     *
     * @var StateInterface[]
     */
    private $states;

    /**
     * Converts the state to a human readable string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $export = sprintf(
            '%s: %s',
            $this->getIdentifier(),
            $this->getValue()
        );

        if ($this->states !== null && count($this->states) > 0) {
            foreach ($this->states as $state) {
                $export .= sprintf(
                    '%s%s%s',
                    static::LINEBREAK,
                    static::INDENTATION,
                    preg_replace(
                        "/(\r\n|\n|\r)/",
                        sprintf("$1%s", static::INDENTATION),
                        $state->__toString()
                    )
                );
            }
        }

        return $export;
    }

    /**
     * Sets the value of the state.
     *
     * @param string $value The value of the state.
     *
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * Retrieves the value of the state.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Sets the identifier of the state.
     *
     * @param string $identifier The identifier of the state.
     *
     * @return void
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * Retrieves the identifier of the state.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Converts the state to an array.
     *
     * @return array
     */
    public function exportState(): array
    {
        $subStates = [];
        if ($this->states !== null && count($this->states) > 0) {
            $subStates['states'] = [];
            foreach ($this->states as $state) {
                $subStates['states'] = array_merge($subStates['states'], $state->exportState());
            }
        }

        return array_merge(
            [$this->getIdentifier() => $this->getValue()],
            $subStates
        );
    }

    /**
     * Adds a state to the state.
     *
     * @param StateInterface $state The state that should be a sub-state of this state.
     */
    public function addState(StateInterface $state): void
    {
        $this->states[] = $state;
    }
}
