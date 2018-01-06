<?php

namespace Kosv\DslTools\Tests\Unit;

use Kosv\DslTools\Document;
use Kosv\DslTools\Streams\FileStream;

class DocumentTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var string
     */
    protected $testFile;

    public function _before()
    {
        $this->testFile = codecept_data_dir() . 'complex_dict.dsl';
    }

    public function testName()
    {
        $document = new Document(new FileStream($this->testFile));

        $this->tester->assertEquals('Complex Dict (Eng-Rus)', $document->getName());
    }

    public function testIndexLanguage()
    {
        $document = new Document(new FileStream($this->testFile));

        $this->tester->assertEquals('English', $document->getIndexLanguage());
    }

    public function testContentsLanguage()
    {
        $document = new Document(new FileStream($this->testFile));

        $this->tester->assertEquals('Russian', $document->getContentsLanguage());
    }

    public function testEncoding()
    {
        $document = new Document(new FileStream($this->testFile));

        $this->tester->assertEquals('UTF-8', $document->getEncoding());
    }

    public function testCardCount()
    {
        $document = new Document(new FileStream($this->testFile));

        $this->tester->assertEquals(21, $document->getCards()->count());
    }
}