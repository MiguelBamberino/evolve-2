<?php
use PHPUnit\Framework\TestCase;
use evolve\Position;
use evolve\Entity;
use evolve\Collections\PositionCollection;

class PositionCollectionTest extends TestCase
{
    /**
     * test we can build a collection and count it
     */
    public function testBasicConstruction(){
        $collection = new PositionCollection($this->basicConstructionProvider());
        $this->assertEquals(9,$collection->count());
    }
    /**
     * test we can build a collection and check pos key
     * @depends testBasicConstruction
     */
    public function testKeyedConstruction(){
        $collection = new PositionCollection($this->basicConstructionProvider());
        $this->assertEquals(true,$collection->has("4-5"));
    }
    /**
     * test we can push onto a collection and it is keyed
     * @depends testKeyedConstruction
     */
    public function testPush(){
        $collection = new PositionCollection($this->basicConstructionProvider());
        $collection->push( new Position(3,6) );
        $this->assertEquals(true,$collection->has("3-6"));
    }
    /**
     * test we can search and get by int coords
     * @depends testKeyedConstruction
     */
    public function testgetByCoordsExist(){
        $collection = new PositionCollection($this->basicConstructionProvider());
        $pos =  $collection->getByCoords(3,4);
        $this->assertEquals("3-4", $pos->x() ."-".$pos->y() );
    }
    /**
     * test we can search and get by int coords
     * @depends testKeyedConstruction
     */
    public function testgetByCoordsNotExist(){
        $collection = new PositionCollection($this->basicConstructionProvider());
        $pos =  $collection->getByCoords(30,4);
        $this->assertEquals(false, $pos );
    }
    /**
     * @depends testKeyedConstruction
     * @dataProvider GetAdjacentsOfProvider
     */
    public function testGetAdjacentsOf(Position $input_position,$expected_count){
        $collection = new PositionCollection($this->basicConstructionProvider());
        $found =  $collection->getAdjacentsOf($input_position);
        $this->assertEquals($expected_count, $found->count() );
    }
    /**
     * test we can search for occupied positions only
     * @depends testKeyedConstruction
     */
    public function testgetOccupied(){
        $collection = new PositionCollection($this->constructionWithEntities());
        $this->assertEquals(3, $collection->getOccupied()->count() );
    }
    /**
     * test we can search for unoccupied positions only
     * @depends testKeyedConstruction
     */
    public function testgetUnOccupied(){
        $collection = new PositionCollection($this->constructionWithEntities());
        $this->assertEquals(6, $collection->getUnoccupied()->count() );
    }
    /**
     * test we can search for occupants of position collection
     * @depends testKeyedConstruction
     */
    public function testgetOccupants(){
        $collection = new PositionCollection($this->constructionWithEntities());
        $this->assertEquals(3, $collection->getOccupants()->count() );
    }    
    /**
     * test we can search for occupants of position collection
     * @depends testKeyedConstruction
     * @dataProvider getOccupantsAdjacentToProvider
     */
    public function testgetOccupantsAdjacentTo(Position $pos, $expected_neighbours){
        $collection = new PositionCollection($this->constructionWithEntities());
        $this->assertEquals($expected_neighbours, $collection->getOccupantsAdjacentTo($pos)->count() );
    }
    /**
     * 
     */
    public function basicConstructionProvider(){
        return array(
            'tl'=>new Position(3,5),
            'tc'=>new Position(4,5),
            'tr'=>new Position(5,5),
            'cl'=>new Position(3,4),
            'cc'=>new Position(4,4),
            'cr'=>new Position(5,4),
            'bl'=>new Position(3,3),
            'bc'=>new Position(4,3),
            'br'=>new Position(5,3),
        );
    }
    /**
     *
     */
    public function constructionWithEntities(){
        $data = $this->basicConstructionProvider();
        $data['tc']->place(new Entity($data['tc'],100));
        $data['cl']->place(new Entity($data['cl'],100));
        $data['bl']->place(new Entity($data['bl'],100));
        return $data;
    }
    public function getOccupantsAdjacentToProvider(){
        return array(
            array(new Position(1,1),0),
            
            array(new Position(5,3),0),
            array(new Position(5,5),1),
            array(new Position(3,5),2),
            array(new Position(3,3),1),
            array(new Position(4,4),3),
            array(new Position(4,3),2),
            array(new Position(2,3),2),
        );
    }
    public function GetAdjacentsOfProvider(){
        return array(
            array(new Position(1,1),0),
            
            array(new Position(2,6),1),
            array(new Position(2,5),2),
            array(new Position(2,4),3),
            array(new Position(2,3),2),
            array(new Position(2,2),1),
            
            array(new Position(3,6),2),
            array(new Position(3,5),3),
            array(new Position(3,4),5),
            array(new Position(3,3),3),
            array(new Position(3,2),2),
            
            array(new Position(4,6),3),
            array(new Position(4,5),5),
            array(new Position(4,4),8),
            array(new Position(4,3),5),
            array(new Position(4,2),3),
            
            array(new Position(5,6),2),
            array(new Position(5,5),3),
            array(new Position(5,4),5),
            array(new Position(5,3),3),
            array(new Position(5,2),2),
            
            array(new Position(6,6),1),
            array(new Position(6,5),2),
            array(new Position(6,4),3),
            array(new Position(6,3),2),
            array(new Position(6,2),1),
        );
    }
}