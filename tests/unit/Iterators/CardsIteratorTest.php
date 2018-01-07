<?php

namespace Kosv\DslTools\Tests\Unit\Iterators;

use OutOfRangeException;
use Kosv\DslTools\Card;
use Kosv\DslTools\Document;
use Kosv\DslTools\Iterators\CardsIterator;
use Kosv\DslTools\Streams\FileStream;

class CardsIteratorTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var string
     */
    protected $testFileName;

    /**
     * @var string
     */
    protected $testFile;

    public function _before()
    {
        $this->testFileName = 'complex_dict.dsl';
        $this->testFile = codecept_data_dir() . $this->testFileName;
    }

    public function testCount()
    {
        $document = new Document(new FileStream($this->testFile));
        $iterator = new CardsIterator($document);

        $this->tester->assertCount(21, $iterator);
    }

    public function testNext()
    {
        $document = new Document(new FileStream($this->testFile));
        $iterator = new CardsIterator($document);

        $iterator->next();
        $this->tester->assertEquals(1, $iterator->key(), 'First shift');
        $iterator->next();
        $this->tester->assertEquals(2, $iterator->key(), 'Second shift');
        $iterator->next();
        $this->tester->assertEquals(3, $iterator->key(), 'Third shift');
    }

    public function testSeekValid()
    {
        $document = new Document(new FileStream($this->testFile));
        $iterator = new CardsIterator($document);

        $iterator->seek(0);
        $this->tester->assertNotNull($iterator->key(), 'The key must not be null');
        $this->tester->assertEquals(0, $iterator->key(), 'The first card must be seeked');
        $iterator->seek(10);
        $this->tester->assertEquals(10, $iterator->key(), 'Any valid the card must be seeked');
        $iterator->seek(20);
        $this->tester->assertEquals(20, $iterator->key(), 'The last card must be seeked');
    }

    public function testSeekInvalidIndex()
    {
        $document = new Document(new FileStream($this->testFile));
        $iterator = new CardsIterator($document);

        $this->tester->expectException(new OutOfRangeException('Invalid card index: 21'), function () use ($iterator) {
            $iterator->seek(21);
        });

        $this->tester->expectException(new OutOfRangeException('Invalid card index: -1'), function () use ($iterator) {
            $iterator->seek(-1);
        });

    }

    public function testRewind()
    {
        $document = new Document(new FileStream($this->testFile));
        $iterator = new CardsIterator($document);

        $iterator->seek(10);
        $iterator->rewind();

        $this->tester->assertNotNull($iterator->key(), 'After rewinding the key must not be null');
        $this->tester->assertEquals(0, $iterator->key(), 'After rewinding the key must be 0');
    }

    public function testValid()
    {
        $document = new Document(new FileStream($this->testFile));
        $iterator = new CardsIterator($document);

        $this->tester->assertTrue($iterator->valid(), 'The second card must be available');
        $iterator->seek(10);
        $this->tester->assertTrue($iterator->valid(), 'The eleventh card must be available');
        $iterator->seek(20);
        $this->tester->assertFalse($iterator->valid(), 'A non-existent card must be unavailable');
    }

    public function testCurrent()
    {
        $document = new Document(new FileStream($this->testFile));
        $iterator = new CardsIterator($document);

        $this->tester->assertInstanceOf(Card::class, $iterator->current());
    }

}