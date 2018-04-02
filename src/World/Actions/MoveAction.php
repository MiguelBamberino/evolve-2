<?php
namespace evolve\World\Actions;

use evolve\World\World;
use evolve\World\Position;
use evolve\World\Entity;
use evolve\World\Condition;

class MoveAction implements iAction{
  
  protected $where;
  
    public function __construct($how=null){
        $this->where = $how;
    }
  
    private function decideTarget(Entity $e, World $w, Condition $c){
        switch($this->where){
                case 'TL':
                    $pos = $e->position();
                    return $w->getPositions()->getByCoords($pos->x()-1,$pos->y()+1);
                break;
                case 'TC':
                    $pos = $e->position();
                    return $w->getPositions()->getByCoords($pos->x(),$pos->y()+1);
                break;
                case 'TR':
                    $pos = $e->position();
                    return $w->getPositions()->getByCoords($pos->x()+1,$pos->y()+1);
                break;
            
                 case 'CL':
                    $pos = $e->position();
                    return $w->getPositions()->getByCoords($pos->x()-1,$pos->y());
                break;
                 case 'CR':
                    $pos = $e->position();
                    return $w->getPositions()->getByCoords($pos->x()+1,$pos->y());
                break;
            
                 case 'BL':
                    $pos = $e->position();
                    return $w->getPositions()->getByCoords($pos->x()-1,$pos->y()-1);
                break;
                 case 'BC':
                    $pos = $e->position();
                    return $w->getPositions()->getByCoords($pos->x(),$pos->y()-1);
                break;
                 case 'BR':
                    $pos = $e->position();
                    return $w->getPositions()->getByCoords($pos->x()+1,$pos->y()-1);
                break;
            
                 case 'RA': # random
                    $pos = $e->position();
                    $xo = rand(0,2)-1;
                    $yo = rand(0,2)-1;
                    return $w->getPositions()->getByCoords($pos->x()+$xo,$pos->y()+$yo);
                break;
            
        }
    }
  
    public function perform(Entity $e, World $w, Condition $c){
        // decide new position
        $target = $this->decideTarget($e, $w, $c);
        if($target instanceof Position){
            return $e->placeAt($target);
        }else{
            return false;
        }
    }
}
  