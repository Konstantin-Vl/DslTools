<?php

namespace Kosv\DslTools;

use Kosv\DslTools\Contracts\IStream;

class Document
{
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
        // TODO: Implement __construct() method.
    }

    /**
     * @return \Kosv\DslTools\Iterators\CardsIterator
     */
    public function getCards()
    {
        // TODO: Implement getCards() method.
    }

    /**
     * @return string|null
     */
    public function getContentsLanguage()
    {
        // TODO: Implement getContentsLanguage() method.
    }

    /**
     * @return string|null
     */
    public function getEncoding()
    {
        // TODO: Implement getEncoding() method.
    }

    /**
     * @return string|null
     */
    public function getIndexLanguage()
    {
        // TODO: Implement getIndexLanguage() method.
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }

}