<?php
namespace evolve\World;

class AbsorbAction implements Action{
  
  protected $where;
  
    public function __construct($how=null){
        $this->where = $how;
    }
    public function perform(Entity $e, World $w, Condition $c){
      $e->increaseEnergy(1);
    }
  
}