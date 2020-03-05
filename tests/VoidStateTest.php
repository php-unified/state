<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace PhpUnified\State\Tests;

use PhpUnified\State\Common\StateInterface;
use PhpUnified\State\VoidState;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \PhpUnified\State\VoidState
 */
class VoidStateTest extends TestCase
{
    /**
     * Covers the entire VoidState class.
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
        $subject = new VoidState();

        $this->assertInstanceOf(VoidState::class, $subject);

        $stateMock = $this->createMock(StateInterface::class);
        $stateMock->expects(self::never())->method(self::anything());

        $subject->addState($stateMock);

        $subject->setValue('qux');
        $this->assertEquals('', $subject->getValue());

        $subject->setIdentifier('baz');
        $this->assertEquals('', $subject->getIdentifier());

        $this->assertEquals([], $subject->exportState());

        $this->assertEquals('', $subject->__toString());
    }
}
