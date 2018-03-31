<?php
namespace evolve\World;

class Position{
    
	protected $x;
	protected $y;
    protected $occupant;
    
    /**
     * construct a position
     * @test PositionTest::basicConstruction
     * @param int $x -> value on the x axis
     * @param int $y -> value on the y axis
     */
	public function __construct($x,$y){
		$this->x = $x;
		$this->y = $y;
	}
	public function x(){
		return $this->x;
	}
	public function y(){
		return $this->y;
	}
    /**
     * place an entity at this position
     * @test PositionTest::testPlace
     * @param Entity $entity -> what to place
     * @return boolean success
     */
    public function place(Entity $entity){
        if($this->occupied()){
            return false;
        }else{
            $this->occupant = $entity;
            return true;
        }
    }
    /** 
     * is the position occupied ?
     * @test PositionTest::testClear
     * @return boolean
     */
    public function occupied(){
        return !empty($this->occupant);
    }
    /**
     * @return Entity $occupant
     */
    public function occupant(){
        return $this->occupant;
    }
    /**
     * remove entity reference fom the position, emptying it
     * @test PositionTest::testClear
     */
    public function clear(){
		$this->occupant = null;
	}
}
