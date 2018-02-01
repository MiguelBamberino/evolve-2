<?php

namespace evolve\Collections;
use evolve\Entity;

class EntityCollection extends AbstractCollection{

    /**
     * @param array $positions -> array of evolve\Entity ojects
     */
    public function __construct(array $entities = array()){
        foreach($entities as $e){
            $key = $this->buildKey($e->position());
            $this->set( $key ,$pos);
        }
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
    public function getAt($x,$y){
        return $this->get( $this->buildKeyFromCoord($x,$y) );
    }
    public function inPattern($pattern){

    }
	
}