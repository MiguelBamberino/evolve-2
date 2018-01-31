<?php

namespace evolve\Collections;
use evolve\Position;

class PositionCollection extends AbstractCollection{
    
    /**
     * @param array $positions -> array of evolve\Position ojects
     */
    public function __construct(array $positions = array()){
        foreach($positions as $pos){
            $key = $this->buildKey($pos);
            $this->set( $key ,$pos);
        }
    }
    /**
     * @param mixed $item -> the position to push on the collection
     */
    public function push(Position $pos){
        $key = $this->buildKey($pos);
        $this->set( $key ,$pos);
    }
    /**
     * build a composite key from x,y values of a position
     * @param Position $pos -> position to key
     * @return string $key
     */
    private function buildKey(Position $pos){
        return $this->buildKeyFromCoord($pos->x(),$pos->y());
    }
    /**
     * build a composite key from x,y values of a position
     * @param int $x -> x coord to key
     * @param int $y -> y coord to key
     * @return string $key
     */
    private function buildKeyFromCoord($x,$y){
        return $x ."-".$y;
    }
    /**
     * @param int $x 
     * @param int $y
     * @return evolve\Position|false $position
     */
    public function getByCoords($x,$y){
       return $this->get( $this->buildKeyFromCoord($x,$y) );
    }
    /**
     * get a collection of all the adjacent positions to
     * the one passed in
     * @param Position $pos -> position to use as centre
     * @return PositionCollection $positions
     */
    public function getAdjacentsOf(Position $pos){
        $x = $pos->x();
        $y = $pos->y();
        $search = array();
        $search[0] = $this->getByCoords($x-1,$y-1);
        $search[1] = $this->getByCoords($x,$y-1);
        $search[2] = $this->getByCoords($x+1,$y-1);
        $search[3] = $this->getByCoords($x-1,$y);
        $search[4] = $this->getByCoords($x+1,$y);
        $search[5] = $this->getByCoords($x-1,$y+1);
        $search[7] = $this->getByCoords($x,$y+1);
        $search[8] = $this->getByCoords($x+1,$y+1);
        $positions = new PositionCollection();
        foreach($search as $s){
            if($s !== false){
                $positions->push($s);
            }
        }
        return $positions;
    }
    /**
     * Get a sub collection of the positions that
     * are occupied.
     * @return PositionCollection $positions
     */
    public function getOccupied(){
        $positions = new PositionCollection();
        foreach($this as $key=>$pos){
            if($pos->occupied()){
                $positions->push($pos);
            }
        }
        return $positions;
    }
    /**
     * Get a sub collection of the positions that
     * are not occupied.
     * @return PositionCollection $positions
     */
    public function getUnoccupied(){
        $positions = new PositionCollection();
        foreach($this as $key=>$pos){
            if(!$pos->occupied()){
                $positions->push($pos);
            }
        }
        return $positions;
    }
    /**
     * @return EntityCollection $collections -> of entities that occupy the positions
     */
    public function getOccupants(){
        $entities = new EntityCollection();
        foreach($this as $key=>$pos){
            if($pos->occupied()){
                $entities->push($pos->occupant());
            }
        }
        return $entities; 
    }
}