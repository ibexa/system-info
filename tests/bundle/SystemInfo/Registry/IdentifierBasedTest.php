<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace Ibexa\Tests\Bundle\SystemInfo\SystemInfo\Registry;

use Ibexa\Bundle\SystemInfo\SystemInfo\Collector\SystemInfoCollector;
use Ibexa\Bundle\SystemInfo\SystemInfo\Registry\IdentifierBased;
use Ibexa\Core\Base\Exceptions\NotFoundException;
use PHPUnit\Framework\TestCase;

class IdentifierBasedTest extends TestCase
{
    private IdentifierBased $registry;

    /**
     * @var array<string, SystemInfoCollector>
     */
    private array $testItems;

    protected function setUp(): void
    {
        $this->testItems = [
            'foo' => $this->createMock(SystemInfoCollector::class),
            'bar' => $this->createMock(SystemInfoCollector::class),
        ];

        $this->registry = new IdentifierBased();
    }

    /**
     * Test adding items to the registry, and getting items from it.
     *
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Registry\IdentifierBased::getItem
     */
    public function testAddAndGetItems(): void
    {
        $this->registry = new IdentifierBased($this->testItems);

        self::assertSame($this->testItems['foo'], $this->registry->getItem('foo'));
        self::assertSame($this->testItems['bar'], $this->registry->getItem('bar'));
    }

    /**
     * Test exception when registry item is not found.
     *
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Registry\IdentifierBased::getItem
     */
    public function testGetItemNotFound(): void
    {
        $this->expectException(NotFoundException::class);
        $this->registry->getItem('notfound');
    }

    /**
     * Test replacing an item in the registry.
     *
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Registry\IdentifierBased::getItem
     */
    public function testReplaceItem(): void
    {
        $this->registry = new IdentifierBased($this->testItems);

        $replaceItems = [
            'foo' => $this->createMock('Ibexa\\Bundle\\SystemInfo\\SystemInfo\\Collector\\SystemInfoCollector'),
        ];

        $this->registry = new IdentifierBased($replaceItems);

        self::assertNotSame($this->testItems['foo'], $this->registry->getItem('foo'));
        self::assertSame($replaceItems['foo'], $this->registry->getItem('foo'));
    }

    /**
     * Test getting all registered identifiers.
     *
     * @covers \Ibexa\Bundle\SystemInfo\SystemInfo\Registry\IdentifierBased::getItem
     *
     * @depends testAddAndGetItems
     */
    public function testGetIdentifiers(): void
    {
        $this->registry = new IdentifierBased($this->testItems);

        $expectedIdentifiers = array_keys($this->testItems);
        sort($expectedIdentifiers);

        $actualIdentifiers = $this->registry->getIdentifiers();
        sort($actualIdentifiers);

        self::assertEquals($expectedIdentifiers, $actualIdentifiers);
    }
}
