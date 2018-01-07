<?php

namespace Kosv\DslTools\Iterators;

use Countable;
use OutOfRangeException;
use Kosv\DslTools\Contracts\IReadable;
use Kosv\DslTools\Card;
use Kosv\DslTools\Document;
use Kosv\DslTools\Parser;

class CardsIterator implements IReadable, Countable
{
    /**
     * @var array
     */
    private $cardPointers = [];

    /**
     * @var int
     */
    private $currentCard = 0;

    /**
     * @var \Kosv\DslTools\Document
     */
    private $document;

    /**
     * CardsIterator constructor.
     *
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->parseCards();
    }

    /**
     * @return \Kosv\DslTools\Card
     */
    public function current()
    {
        $stream = $this->document->getStream();

        $begin = $this->getPointers($this->key())['begin'];
        $end   = $this->getPointers($this->key())['end'];
        $cardData = [];
        for ($i = $begin; $i <= $end; $i++) {
            $stream->seek($i);
            $cardData[] = $stream->current();
        }

        return new Card($cardData);
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->seek($this->key() + 1);
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->currentCard;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        if ($this->key() + 1 > $this->count() - 1) {
            return false;
        }

        return true;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->seek(0);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->cardPointers);
    }

    /**
     * @param int $cardIndex
     * @return \Kosv\DslTools\Card
     */
    public function seek($cardIndex)
    {
        if ($cardIndex > $this->count() - 1 || $cardIndex < 0) {
            throw new OutOfRangeException("Invalid card index: {$cardIndex}");
        }

        $this->currentCard = $cardIndex;
    }

    /**
     * @param int $cardIndex
     * @return array
     */
    protected function getPointers($cardIndex)
    {
        if (!isset($this->cardPointers[$cardIndex])) {
            throw new OutOfRangeException("No data for card: {$cardIndex}");
        }

        return $this->cardPointers[$cardIndex];
    }

    /**
     * @return void
     */
    protected function parseCards()
    {
        $stream = $this->document->getStream();
        $stream->rewind();

        $parser = new Parser();
        $beginCard = null; $endCard = null;

        while ($stream->valid()) {
            if ($parser->match(Parser::CARD_HEAD, $stream->current())) {
                $beginCard = $stream->key();
                if ($stream->valid()) {
                    $stream->next();
                    while ($stream->valid() && $parser->match(Parser::CARD_BODY, $stream->current())) {
                        $endCard = $stream->key();
                        $stream->next();
                    }
                }

            }
            if (is_int($beginCard) && is_int($endCard)) {
                $this->cardPointers[] = ['begin' => $beginCard, 'end' => $endCard];
                $beginCard = null; $endCard = null;
                continue;
            }

            $stream->next();
        }
    }
}