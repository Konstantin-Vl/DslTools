<?php

namespace Kosv\DslTools\Iterators;

use Countable;
use Kosv\DslTools\Contracts\IReadable;
use Kosv\DslTools\Document;

class CardsIterator implements IReadable, Countable
{
    /**
     * CardsIterator constructor.
     *
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        // TODO: Implement __construct() method.
    }

    /**
     * @return \Kosv\DslTools\Card|null
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     * @return \Kosv\DslTools\Card|null
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * @return int
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * @return bool
     */
    public function valid()
    {
        // TODO: Implement valid() method.
    }

    /**
     * @return void
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    /**
     * @return int
     */
    public function count()
    {
        // TODO: Implement count() method.
    }

    /**
     * @param int $cardIndex
     * @return \Kosv\DslTools\Card
     */
    public function seek($cardIndex)
    {
        // TODO: Implement seek() method.
    }
}