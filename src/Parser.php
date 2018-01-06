<?php

namespace Kosv\DslTools;

use InvalidArgumentException;

class Parser
{
    const D_NAME = 0;
    const D_INDEX_LANGUAGE = 1;
    const D_CONTENTS_LANGUAGE = 2;
    const D_INCLUDE = 4;
    const D_SOURCE_CODE_PAGE = 5;
    const CARD_HEAD = 6;
    const CARD_BODY = 7;
    const CARD_NODE = 8;

    /**
     * @var array
     */
    private $syntaxMapping = [
        self::D_NAME => [
            'match' => "^#NAME[ \t]+",
            'selectText' => '(?<=").*(?=")'
        ],
        self::D_INDEX_LANGUAGE => [
            'match' => "^#INDEX_LANGUAGE[ \t]+",
            'selectText' => '(?<=").*(?=")'
        ],
        self::D_CONTENTS_LANGUAGE => [
            'match' => "^#CONTENTS_LANGUAGE[ \t]+",
            'selectText' => '(?<=").*(?=")'
        ],
        self::D_INCLUDE => [
            'match' => "^#INCLUDE[ \t]+",
            'selectText' => '(?<=").*(?=")'
        ],
        self::D_SOURCE_CODE_PAGE => [
            'match' => "^#SOURCE_CODE_PAGE[ \t]+",
            'selectText' => '(?<=").*(?=")'
        ],
        self::CARD_HEAD => [
            'match' => "^\S.*",
        ],
        self::CARD_BODY => [
            'match' => "^[ \t]+",
        ]
    ];

    /**
     * @param int $syntaxFor
     * @param string $str
     * @return bool
     */
    public function match($syntaxFor, $str)
    {
        return mb_ereg_match($this->syntaxMapping[$syntaxFor]['match'], $str);
    }

    /**
     * @param int $syntaxFor
     * @param string $str
     * @return string
     * @throws InvalidArgumentException
     */
    public function selectText($syntaxFor, $str)
    {
        if (!isset($this->syntaxMapping[$syntaxFor]['selectText'])) {
            throw new InvalidArgumentException('The syntax element does not support text fetching.');
        }

        $maths = [];
        preg_match("/{$this->syntaxMapping[$syntaxFor]['selectText']}/", $str, $maths);
        return isset($maths[0]) ? $maths[0] : '';
    }
}