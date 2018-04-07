<?php
namespace evolve\World\Actions;

use evolve\World\World;
use evolve\World\Position;
use evolve\World\Entity;
use evolve\World\Condition;

abstract class AbstractEnergyTransferAction implements iAction{
  
  protected $target;
  
    public function __construct($how=null){
        $this->target = $how;
    }

    protected function transfer($source,$target){

      if($target instanceof Entity){
          $source->reduceEnergy(1);
          $target->increaseEnergy(1);   
            return true;
        }else{
            return false;
        }
    }
    protected function decideTarget(Entity $e, World $w, Condition $c){
        
        switch($this->target){
            case 'first':
                $neigbours =$w->GetPositions()->getOccupantsAdjacentTo($e->position());
                return $neigbours->getFirst();
                break;
        }
    }
  
}