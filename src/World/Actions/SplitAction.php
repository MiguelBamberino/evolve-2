<?php
namespace evolve\World\Actions;

use evolve\World\World;
use evolve\World\Position;
use evolve\World\Entity;
use evolve\World\Condition;

class  SplitAction {
  protected $division;
  function __construct($how=null){
    $this->division =$how;
  }
  function perform(Entity $e, World $w, Condition $c){
    
    
    $spots_needed = $this->division - 1;
    $spawned = 0;  
    $spaces = $w->GetPositions()->getAdjacentsOf($e->position())->getUnoccupied();
    if($spaces->count() >= $spots_needed){
      $e_chunk = (int)($e->energy()/$this->division);
      foreach($spaces as $space){
        if($spawned<$spots_needed){
          $limbo = new Position($space->x(),$space->y());
          $spawn = new Entity($limbo,$e_chunk);
          $w->addEntity($spawn);
          $spawned++;
        }else{
          break;
        }
      }
      $e->reduceEnergy($e_chunk*$spots_needed);
    }else{
      return false;
    }
    // find adjacent empty spot
    // take 50& energy
    // place new entitiy at world position 
  }
}