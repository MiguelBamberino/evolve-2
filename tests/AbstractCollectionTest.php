<?php
use PHPUnit\Framework\TestCase;

class testCollection extends evolve\Collections\AbstractCollection{
  
}
class AbstractCollectionTest extends TestCase
{
    /**
     * test we can build a collection and count it
     */
    public function testBasicConstruction(){
        $collection = new testCollection($this->basicConstructionProvider());
        $this->assertEquals(4,$collection->count());
    }
    /**
     * test if we have a given key in a collection
     * @depends testBasicConstruction
     */
    public function testHas(){
        $collection = new testCollection($this->basicConstructionProvider());
        $this->assertEquals(true,$collection->has('mike'));
    }
    /**
     * test if we dont have a given key in a collection
     * @depends testBasicConstruction
     */
    public function testHasNot(){
        $collection = new testCollection($this->basicConstructionProvider());
        $this->assertEquals(false,$collection->has('fred'));
    }
    /**
     * test we can push a new value on the collection
     * @depends testBasicConstruction
     */
    public function testPush(){
        $collection = new testCollection($this->basicConstructionProvider());
        $collection->push('44');
        $this->assertEquals(5,$collection->count());
    }
    /**
     * test we can set a new value on the collection
     * and get it back
     * @depends testHas
     */
    public function testSetAndGet(){
        $collection = new testCollection($this->basicConstructionProvider());
        $collection->set('sam','44');
        $this->assertEquals('44',$collection->get('sam'));
    }
    /**
     * test we can get the first value on the collection
     * @depends testBasicConstruction
     */
    public function testGetFirst(){
        $collection = new testCollection($this->basicConstructionProvider());
        $this->assertEquals('56',$collection->getFirst());
    }
    /**
     * test we can get the last value on the collection
     * @depends testBasicConstruction
     */
    public function testGetLast(){
        $collection = new testCollection($this->basicConstructionProvider());
        $this->assertEquals('39',$collection->getLast());
    }
    /**
     * test we can get the last value on the collection
     * @depends testBasicConstruction
     */
    public function testGetRandom(){
        $collection = new testCollection($this->basicConstructionProvider());
        $v = $collection->getRandom();
        $this->assertEquals(true, in_array($v,array('56','27','29','39')) );
    }
    /**
     *
     */
    public function basicConstructionProvider(){
        return array(
            'bob'=>'56',
            'mike'=>'27',
            'freda'=>'29',
            'frank'=>'39',
        );
    }
}