<?php

namespace Kosv\DslTools;

use LengthException;

class Card
{
    /**
     * @var array
     */
    private $rawBody = [];

    /**
     * @var string
     */
    private $rawHeadText;

    /**
     * @var \Kosv\DslTools\Parser
     */
    protected $parser;

    /**
     * Card constructor.
     *
     * @param string|array $rawCard
     */
    public function __construct($rawCard)
    {
        $this->parser = new Parser();
        $this->prepareObject($rawCard);
    }

    /**
     * @return string
     */
    public function getHeadText()
    {
        return (string) $this->parser
            ->rmMetadata(Parser::CARD_HEAD, trim($this->rawHeadText));
    }

    /**
     * @return \Kosv\DslTools\Node[]
     */
    public function getNodes()
    {
        $nodes = [];
        foreach ($this->rawBody as $rawNode) {
            $nodes[] = new Node($rawNode);
        }

        return $nodes;
    }

    /**
     * @param string|array $rawCard
     * @throws LengthException
     */
    private function prepareObject($rawCard)
    {
        if (!is_array($rawCard)) {
            $rawCard = explode("\n", $rawCard);
        }

        if (!$rawCard) {
            throw new LengthException('The card can not be zero length');
        }

        if ($this->parser->match(Parser::CARD_HEAD, $rawCard[0])) {
            $this->rawHeadText = $rawCard[0];
            unset($rawCard[0]);
        }

        array_map(function ($value) {
            if ($this->parser->match(Parser::CARD_BODY, $value)) {
                $this->rawBody[] = $value;
            }
        }, $rawCard);
    }

}