<?php

namespace Kosv\DslTools\Tests\Unit;

use Kosv\DslTools\Card;

class CardTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @return array
     */
    public function headTextProvider()
    {
        return [
            [$this->getCardData('array'), '(tele)phone'],
            [$this->getCardData('string'), '(tele)phone'],
        ];
    }

    /**
     * @dataProvider headTextProvider
     */
    public function testHeadText($rawCard, $excepted)
    {
        $card = new Card($rawCard);

        $this->tester->assertEquals($excepted, $card->getHeadText());
    }

    /**
     * @return array
     */
    public function countNodesProvider()
    {
        return [
            [$this->getCardData('array'), 10],
            [$this->getCardData('string'), 10],
        ];
    }

    /**
     * @dataProvider countNodesProvider
     */
    public function testCountNodes($rawCard, $excepted)
    {
        $card = new Card($rawCard);

        $this->tester->assertCount($excepted, $card->getNodes());
    }

    protected function getCardData($type)
    {
        $data = [
            'array' => [
                "{(}tele{)}phone",
                "	[c chocolate][t]\['telɪfəun\][/t][/c]",
                "	[m1][b][c darkred]1.[/c][/b] [p]n[/p][/m]",
                "	[m2][trn]телефон[/trn][/m]",
                "	[m3][*][ex][lang name=\"English\"][b]mobile phone[/b][/lang] — мобильный телефон[/ex][/*][/m]",
                "	[m1][b][c darkred]2.[/c][/b] [p]adj[/p][/m]",
                "	[m2][trn]телефонный[/trn][/m]",
                "	[m3][*][ex][lang name=\"English\"][b]telephone card[/b][/lang] — телефонная карточка[/ex][/*][/m]",
                "	[m1][b][c darkred]3.[/c][/b] [p]v[/p][/m]",
                "	[m2][trn](по)звонить по телефону; передавать по телефону[/trn][/m]",
                "	[m3][*][ex][lang name=\"English\"][b]to phone a friend[/b][/lang] — позвонить другу[/ex][/*][/m]"
            ],
            'string' => "{(}tele{)}phone" . "\r\n" .
            "	[c chocolate][t]\['telɪfəun\][/t][/c]" . "\r\n" .
            "	[m1][b][c darkred]1.[/c][/b] [p]n[/p][/m]" . "\r\n" .
            "	[m2][trn]телефон[/trn][/m]" . "\r\n" .
            "	[m3][*][ex][lang name=\"English\"][b]mobile phone[/b][/lang] — мобильный телефон[/ex][/*][/m]" . "\r\n" .
            "	[m1][b][c darkred]2.[/c][/b] [p]adj[/p][/m]" . "\r\n" .
            "	[m2][trn]телефонный[/trn][/m]" . "\r\n" .
            "	[m3][*][ex][lang name=\"English\"][b]telephone card[/b][/lang] — телефонная карточка[/ex][/*][/m]" . "\r\n" .
            "	[m1][b][c darkred]3.[/c][/b] [p]v[/p][/m]" . "\r\n" .
            "	[m2][trn](по)звонить по телефону; передавать по телефону[/trn][/m]" . "\r\n" .
            "	[m3][*][ex][lang name=\"English\"][b]to phone a friend[/b][/lang] — позвонить другу[/ex][/*][/m]" . "\r\n"
        ];

        return $data[$type];
    }
}