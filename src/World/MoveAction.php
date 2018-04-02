<?php
namespace evolve\World;

class MoveAction implements Action{
  
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
  