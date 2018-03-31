<?php
use PHPUnit\Framework\TestCase;
use evolve\World\World;
use evolve\World\Position;

use evolve\World\Entity;

class ConditionTest extends TestCase
{
    /**
     * test we can carry out basic construction
     */
    public function testBasicConstruction(){

        $pos =  new Position(45,34);
        $entity =  new Entity($pos,100);
        $this->assertEquals(179,$entity->position()->x()+$entity->position()->y()+$entity->energy());

    }