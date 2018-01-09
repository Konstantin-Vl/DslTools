<?php

namespace Kosv\DslTools\Tests\Unit;

use Kosv\DslTools\Node;

class NodeTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @return array
     */
    public function countNodesProvider()
    {
        return [
            ["[m1][trn]зона, пояс, полоса; область[/trn][/m]", 1],
            ["  [c chocolate][t]\[zu:\][/t][/c] [p]n[/p]", 2],
            ["[trn][p]зоол.[/p] [p]терм.[/p] помесь верблюда и ламы[/trn]", 2]
        ];
    }

    /**
     * @dataProvider countNodesProvider
     */
    public function testCountNodes($rawNode, $excepted)
    {
        $node = new Node($rawNode);

        $this->tester->assertCount($excepted, $node->getNods());
    }

    public function testGetAttr()
    {
        $node = new Node("[lang name=\"English\"][b]one cannot account for tastes[/b][/lang]");

        $this->tester->assertEquals('English', $node->getAttr('name'));
    }

    public function testGetName()
    {
        $node = new Node("[m1][trn]зона, пояс, полоса; область[/trn][/m]");

        $this->tester->assertEquals('m1', $node->getName());
    }

    public function testGetNameEmpty()
    {
        $node = new Node("   [c chocolate][t]\['telɪfəun\][/t][/c]");

        $this->tester->assertEmpty($node->getName());
    }

    public function testGetParent()
    {
        $parentNode = new Node("[m1][trn]зона, пояс, полоса; область[/trn][/m]");
        $childNode  = new Node("[trn]зона, пояс, полоса; область[/trn]");
        $childNode->setParent($parentNode);

        $this->tester->assertEquals('m1', $childNode->getParent()->getName());
    }

    public function testHasParent()
    {
        $parentNode = new Node("[m1][trn]зона, пояс, полоса; область[/trn][/m]");
        $childNode  = new Node("[trn]зона, пояс, полоса; область[/trn]");
        $childNode->setParent($parentNode);

        $this->tester->assertTrue($childNode->hasParent());
    }

    /**
     * @return array
     */
    public function getTextProvider()
    {
        return [
            ["[m1][trn][p]зоол.[/p] [p]терм.[/p] помесь верблюда и ламы[/trn][/m]", ''],
            ["[trn][p]зоол.[/p] [p]терм.[/p] помесь верблюда и ламы[/trn]", ' помесь верблюда и ламы'],
            ["[p]зоол.[/p]", 'зоол.']
        ];
    }

    /**
     * @dataProvider getTextProvider
     */
    public function testGetText($rawNode, $excepted)
    {
        $node = new Node($rawNode);

        $this->tester->assertEquals($excepted, $node->getText());
    }
}