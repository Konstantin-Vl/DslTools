<?php

namespace Kosv\DslTools\Tests\Unit\Helpers;

use Kosv\DslTools\Helpers\FileHelper;

class FileHelperTest extends \Codeception\Test\Unit
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
        $this->testFile = 'complex_dict.dsl';
    }

    public function _after()
    {
        // Removing temporary files
        foreach (glob(codecept_output_dir() . '/*.utf-8.tmp') as $tmpFile) {
            unlink($tmpFile);
        }
    }

    public function testConvertToUtf8()
    {
        $tmpFile = FileHelper::convertToUtf8(codecept_data_dir() . $this->testFile, 'UTF-16', codecept_output_dir());

        $this->tester->assertEquals(codecept_output_dir() . "{$this->testFile}.utf-8.tmp", $tmpFile->getPathname());
        $this->tester->assertTrue($tmpFile->isFile());
    }
}