<?php
namespace evolve\World\Actions;

use evolve\World\World;
use evolve\World\Position;
use evolve\World\Entity;
use evolve\World\Condition;

class GiveAction extends AbstractEnergyTransferAction{
  
    public function perform(Entity $e, World $w, Condition $c){
      $target = $this->decideTarget($e,$w,$c);
      return $this->transfer($e,$target);        
    }

  
}