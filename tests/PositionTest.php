<?php
use PHPUnit\Framework\TestCase;
use  evolve\World\Position;
use  evolve\World\Entity;

class PositionTest extends TestCase
{
    /**
     * test can we build a basic position object
     */
    public function testBasicConstruction(){

        $pos = new  Position(45,34);
        $this->assertEquals(79,$pos->x()+$pos->y());
    } 
    /**
     * test we can place an entity at this position
     * @depends testBasicConstruction
     */
    public function testCanPlace(){
        
        $pos = new  Position(45,34);
        $placed = $pos->place( new  entity($pos,100) );
        $this->assertEquals(true,$placed);
    }
    /**
     * test we can place an entity at this position
     * @depends testCanPlace
     */
    public function testCantPlace(){
        
        $pos = new  Position(45,34);
        $pos = new  Position(46,34);
        $pos->place( new  entity($pos,100) );
        $placed = $pos->place( new  entity($pos,100) );
        $this->assertEquals(false,$placed);
    }
    /**
     * test we can place an entity at this position
     * @depends testBasicConstruction
     */
    public function testClearPlace(){
        
        $pos = new  Position(45,34);
        $pos->place( new  entity($pos,100) );
        $pos->clear();
        
        $this->assertEquals(false,$pos->occupied());
    }
    /**
     * test we can retrieve an entity at this position
     * @depends testBasicConstruction
     */
    public function testOccupant(){
        
        $pos = new  Position(45,34);
        $pos->place( new  entity($pos,100) );
        
        
        $this->assertEquals(100,$pos->occupant()->energy());
    }
}