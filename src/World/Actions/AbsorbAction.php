<?php
namespace evolve\World\Actions;

use evolve\World\World;
use evolve\World\Position;
use evolve\World\Entity;
use evolve\World\Condition;

class AbsorbAction implements iAction{
  
  protected $where;
  
    public function __construct($how=null){
        $this->where = $how;
    }
    public function perform(Entity $e, World $w, Condition $c){
      $e->increaseEnergy(1);
    }
  
}