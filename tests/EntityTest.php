<?php
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    /**
     * test we can carry out basic construction
     */
    public function testBasicConstruction(){

        $pos = new evolve\Position(45,34);
        $entity = new evolve\Entity($pos,100);
        $this->assertEquals(179,$entity->position()->x()+$entity->position()->y()+$entity->energy());

    }
    /**
     * test that after construction and entity enters the correct state
     * @depends testBasicConstruction
     * @dataProvider constructionStateProvider
     */
    public function testConstructionState($x,$y,$energy,$expected){

        $pos = new evolve\Position($x,$y);
        $entity = new evolve\Entity($pos,$energy);
        $this->assertEquals($expected[1],$entity->$expected[0]());

    }
    /**
     * can we change the position of an entity
     * @depends testBasicConstruction
     */
    public function testSetPosition(){
        $pos = new evolve\Position(45,34);
        $entity = new evolve\Entity($pos,100);
        $pos2 = new evolve\Position(5,3);
        $entity->setPosition($pos2);
        $this->assertEquals(108,$entity->position()->x()+$entity->position()->y()+$entity->energy());  
    }
    /**
     * test if we can reduce energy and trigger the correct state change
     * @depends testConstructionState
     * @dataProvider constructionStateProvider
     */
    public function testReduceEnergy($x,$y,$energy,$expected){

        $pos = new evolve\Position($x,$y);
        $energy = $energy+1; // increase energy, to set initial state
        $entity = new evolve\Entity($pos,$energy);
        $entity->reduceEnergy(1);
        $this->assertEquals($expected[1],$entity->$expected[0]());

    } 
    /**
     * test if we can increase energy and trigger the correct state change
     * @depends testConstructionState
     * @dataProvider constructionStateProvider
     */
    public function testIncreaseEnergy($x,$y,$energy,$expected){

        $pos = new evolve\Position($x,$y);
        $energy = $energy-1; // reduce energy, to set initial state
        $entity = new evolve\Entity($pos,$energy);
        $entity->increaseEnergy(1);
        $this->assertEquals($expected[1],$entity->$expected[0]());

    } 
    /**
     * Basic entity construction
     */
    public function constructionStateProvider(){
        return array(
        // test alive state
        array('x'=>5,'y'=>40,'e'=>1,'expected'=>array('alive',true)),
        array('x'=>5,'y'=>40,'e'=>0,'expected'=>array('alive',false)),
        array('x'=>5,'y'=>40,'e'=>-1,'expected'=>array('alive',false)),
        array('x'=>5,'y'=>40,'e'=>-50,'expected'=>array('alive',false)),
        array('x'=>5,'y'=>40,'e'=>-51,'expected'=>array('alive',false)),
        // test dead state
        array('x'=>5,'y'=>40,'e'=>1,'expected'=>array('dead',false)),
        array('x'=>5,'y'=>40,'e'=>0,'expected'=>array('dead',true)),
        array('x'=>5,'y'=>40,'e'=>-1,'expected'=>array('dead',true)),
        array('x'=>5,'y'=>40,'e'=>-50,'expected'=>array('dead',false)),
        array('x'=>5,'y'=>40,'e'=>-51,'expected'=>array('dead',false)),
        // test decayed state
        array('x'=>5,'y'=>40,'e'=>1,'expected'=>array('decayed',false)),
        array('x'=>5,'y'=>40,'e'=>0,'expected'=>array('decayed',false)),
        array('x'=>5,'y'=>40,'e'=>-1,'expected'=>array('decayed',false)),
        array('x'=>5,'y'=>40,'e'=>-50,'expected'=>array('decayed',true)),
        array('x'=>5,'y'=>40,'e'=>-51,'expected'=>array('decayed',true)),
        );
    }
}