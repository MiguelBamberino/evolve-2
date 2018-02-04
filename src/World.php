<?php
namespace evolve;

class World{
    
    $name;
    $width;
    $height;
    $ticks;
    $positions;
    $entities;

    public function __construct($name,$width,$height,$ticks,$entities){
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;
        $this->ticks = $ticks;
        $this->buildPositions();
        foreach($entities as $e){
            $this->placeAt($e->position(),$e);
        }
    }

    public function tickOver(){}
    public function placeAt(Position $pos, Entity $entity){}
  
  public function getEntities(){ return $this->entities;}
  public function getNeighboursOf(Position $pos){ return $this->entities;}
  
  public function getPositions(){return $this->positions;}
  public function getAdjacentPositionsOf(Position $pos){}

}