<?php
namespace evolve\World\Actions;

use evolve\World\World;
use evolve\World\Position;
use evolve\World\Entity;
use evolve\World\Condition;

class TakeAction implements iAction{
  
  protected $target;
  
    public function __construct($how=null){
        $this->target = $how;
    }
    public function perform(Entity $e, World $w, Condition $c){
      $target = $this->decideTarget($e,$w,$c);
        if($target instanceof Entity){
          $target->reduceEnergy(1);
          $e->increaseEnergy(1);   
            return true;
        }else{
            return false;
        }
    }
    private function decideTarget(Entity $e, World $w, Condition $c){
        
        switch($this->target){
            case 'first':
                $neigbours =$w->GetPositions()->getOccupantsAdjacentTo($e->position());
                return $neigbours->getFirst();
                break;
        }
    }
  
}