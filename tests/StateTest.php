<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace PhpUnified\State\Tests;

use PhpUnified\State\Common\StateInterface;
use PhpUnified\State\State;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \PhpUnified\State\State
 */
class StateTest extends TestCase
{
    /**
     * Covers the entire State class.
     *
     * @return void
     *
     * @covers ::__toString
     * @covers ::setValue
     * @covers ::getValue
     * @covers ::setIdentifier
     * @covers ::getIdentifier
     * @covers ::exportState
     * @covers ::addState
     */
    public function testState(): void
    {
        $subject = new State();

        $this->assertInstanceOf(State::class, $subject);

        $stateMock = $this->createMock(StateInterface::class);
        $stateMock->expects(self::once())
            ->method('__toString')
            ->willReturn('foo: bar');

        $stateMock->expects(self::once())
            ->method('exportState')
            ->willReturn(['foo' => 'bar']);

        $subject->addState($stateMock);

        $subject->setValue('qux');
        $this->assertEquals('qux', $subject->getValue());

        $subject->setIdentifier('baz');
        $this->assertEquals('baz', $subject->getIdentifier());

        $this->assertEquals(
            ['baz' => 'qux', 'states' => ['foo' => 'bar']],
            $subject->exportState()
        );

        $this->assertEquals(
            sprintf(
                '%s%s%s',
                'baz: qux',
                PHP_EOL,
                '  foo: bar'
            ),
            $subject->__toString()
        );
    }
}
