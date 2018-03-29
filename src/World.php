<?php
namespace evolve;
use evolve\Collections\PositionCollection;
use evolve\Collections\EntityCollection;

class World{
    
    protected $name;
    protected $width;
    protected $height;
    protected $current_tick;
    protected $positions;
    protected $entities;

    /**
     * BUILD IT !
     * @param string $name -> name of your world
     * @param int $width -> how many positions wide the world is
     * @param int $height -> how many positions heigh the world is
     * @param int $current_tick -> the current world time point
     */
    public function __construct($name,$width,$height,$current_tick,$entities = null){
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;
        $this->current_tick = $current_tick;
        $this->buildPositions();
        // set up the positions by placing the entity
        if(!empty($entities)){
            foreach($entities as $e){
              $cPos = $e->position();
              $newPos = $this->positions->getByCoords($cPos->x(),$cPos->y());
              $e->placeAt($newPos);
            }  
        }
        
    }
    /**
     * build the world position collection from width and height info
     */
    private function buildPositions(){
        $this->positions = new PositionCollection();
        for($y=0;$y<=$this->height;$y++){
            for($x=0;$x<=$this->width;$x++){
                $this->positions->push( new Position($x,$y) );
            }
        }
      
    }
    /**
     * carry out all events of the world for one tick
     * progressing world time by 1 tick
     */
    public function tickOver(){
        
        foreach($this-entities as $key => $entity){
            
            if( $entity->decayed() ){
                $this->remove($key);
            }else{
                $entity->act();
            }
            
        }
        $this->$current_tick++;
        return $current_tick;
    }
    
  
  public function getEntities(){ return $this->entities;}
  public function getNeighboursOf(Position $pos){ return $this->entities;}
  
  public function getPositions(){return $this->positions;}
  public function getAdjacentPositionsOf(Position $pos){}
  
  public function placeAt(Position $pos, Entity $entity){
        $pos = $this->positions->getByCoords($pos->x(),$pos->y());
        #$pos->placeAt($entity->);
    }
  public function name(){
    return $this->name;
  }
  public function width(){
    return $this->width;
  }
  public function height(){
    return $this->height;
  }
  public function current_tick(){
    return $this->current_tick;
  }
}