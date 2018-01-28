<?php

namespace evolve\Collections;
use evolve\Position;

class PositionCollection extends AbstractCollection{
    
    /**
     * @param array $positions -> array of evolve\Position ojects
     */
    public function __construct(array $positions){
        foreach($positions as $pos){
            $key = $this->buildKey($pos);
            $this->set( $key ,$pos);
        }
    }
    private function buildKey(Position $pos){
        return $this->buildKeyFromCoord($pos->x(),$pos->y());
    }
    private function buildKeyFromCoord($x,$y){
        return $x ."-".$y;
    }
    /**
     * @param int $x 
     * @param int $y
     * @return evolve\Position|false $position
     */
    public function getByCoords($x,$y){
        $this->get( $this->buildKeyFromCoord($x,$y) );
    }
    public function getAdjacentsOf($x,$y);
    
    public function getOccupants();
    public function getOccupied();
    public function getUnoccupied();
}