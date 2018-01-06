<?php

namespace Kosv\DslTools;

use Kosv\DslTools\Contracts\IStream;
use Kosv\DslTools\Iterators\CardsIterator;

class Document
{
    /**
     * @var string
     */
    private $contentsLanguage;

    /**
     * @var string
     */
    private $encoding;

    /**
     * @var string
     */
    private $indexLanguage;

    /**
     * @var string
     */
    private $name;

    /**
     * @var IStream
     */
    private $stream;

    /**
     * Document constructor.
     *
     * @param \Kosv\DslTools\Contracts\IStream $stream
     */
    public function __construct(IStream $stream)
    {
        $this->stream = $stream;
        $this->parseDocument();
    }

    /**
     * @return void
     */
    protected function parseDocument()
    {
        $this->stream->rewind();

        $parser = new Parser();
        while ($this->stream->valid()) {
            $currentString = $this->stream->current();

            if ($parser->match(Parser::D_NAME, $currentString)) {
                $this->name = $parser->selectText(Parser::D_NAME, $currentString);
            } elseif ($parser->match(Parser::D_INDEX_LANGUAGE, $currentString)) {
                $this->indexLanguage = $parser->selectText(Parser::D_INDEX_LANGUAGE, $currentString);
            } elseif ($parser->match(Parser::D_CONTENTS_LANGUAGE, $currentString)) {
                $this->contentsLanguage = $parser->selectText(Parser::D_CONTENTS_LANGUAGE, $currentString);
            } elseif ($parser->match(Parser::D_SOURCE_CODE_PAGE, $currentString)) {
                $this->encoding = $parser->selectText(Parser::D_SOURCE_CODE_PAGE, $currentString);
            }

            $this->stream->next();
        }
    }

    /**
     * @return \Kosv\DslTools\Iterators\CardsIterator
     */
    public function getCards()
    {
        return new CardsIterator($this);
    }

    /**
     * @return string|null
     */
    public function getContentsLanguage()
    {
        return $this->contentsLanguage;
    }

    /**
     * @return string|null
     */
    public function getEncoding()
    {
        if ($this->encoding) {
            return $this->encoding;
        }

        return "UTF-8";
    }

    /**
     * @return string|null
     */
    public function getIndexLanguage()
    {
        return $this->indexLanguage;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Kosv\DslTools\Contracts\IStream
     */
    public function getStream()
    {
        return $this->stream;
    }

}