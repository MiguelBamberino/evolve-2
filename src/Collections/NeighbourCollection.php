<?php

namespace evolve\Collections;
use evolve\Entity;

class NeighbourCollection extends AbstractEntityCollection{
    
    protected $centre;
    /**
     * @param Position $centre -> the position the neighbours are situated around
     * @param array $entities -> array of objects of type Entity
     */
    public function __construct(Position $centre, array $entities){
        $this->centre = $centre;
        parent::__construct($entities);
    }
    /**
     * @return boolean -> whether the entities are in the given position pattern
     */
    public function inPattern($pattern){
        switch($pattern){
            case 'x':
                return $this->inXpattern();
                break;
            case '+':
                return $this->inCrossPattern();
            default:
                return false;
                break;
        }
    }
    private function inXpattern(){
        $modifiers= array(
            array(-1,1), // top left
            array(1,1), // top right
            array(-1,-1), // bottom left
            array(1,-1), // bottom right
        );
        
        return $this->__checkAdjacentPatternWithModifierMatrix($modifiers);
    }
    private function inCrosspattern(){
        $modifiers= array(
            array(0,1), // top centre
            array(-1,0), // centre left
            array(1,0), // centre right
            array(0,-1), // bottom centre
        );
        
        return $this->__checkAdjacentPatternWithModifierMatrix($modifiers);
    }
    private function __checkAdjacentPatternWithModifierMatrix($modifiers){
        
        if($this->count()== count($modifiers) ){
            
            foreach($modifiers as $mod){
                $key = $this->buildKeyFromCoord($this->centre->x()+$mod[0],$this->centre->y()+$mod[1]);
                if( !$this->has($key) ){
                    return false;
                }
            }
            return true;
        }else{
           return false;
        }
    }
      private function old_inXpattern(){
        $in = false;
        if($this->count()==4){
            
            $topLeft = $this->buildKeyFromCoord($this->centre->x()-1,$this->centre->y()+1);
            if( $this->has($topLeft) ){
                
                $topRight = $this->buildKeyFromCoord($this->centre->x()+1,$this->centre->y()+1);
                if( $this->has($topRight) ){
                    
                    $bottomLeft = $this->buildKeyFromCoord($this->centre->x()-1,$this->centre->y()-1);
                    if( $this->has($bottomLeft) ){
                        
                        $bottomRight = $this->buildKeyFromCoord($this->centre->x()+1,$this->centre->y()-1);
                        if( $this->has($bottomRight) ){
                            $in = true;
                        }
                    }
                }   
            }
        }
        return $in;
    }
  
}