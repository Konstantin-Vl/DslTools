<?php

namespace Kosv\DslTools;

use SplFileObject as BaseFileObject;
use Kosv\DslTools\Helpers\FileHelper;

class FileObject extends BaseFileObject
{

    const REQUIRED_ENCODING = 'UTF-16';

    /**
     * FileObject constructor.
     *
     * @param string $fileName
     * @param string $openMode
     */
    public function __construct($fileName, $openMode = 'r')
    {
        parent::__construct(
            FileHelper::convertToUtf8($fileName, self::REQUIRED_ENCODING),
            $openMode
        );
    }
}