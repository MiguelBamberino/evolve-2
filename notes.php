<?php

/*

*/

class Behaviour{

  protected $condition;
  protected $action;
  
  public function __construct(Condition $condition, Action $action ){
    $this->condition = $condition;
    $this->action = $action;
  }
  
  public function perform($entity){
  
    if($this->condition->evaluate($entity){
    	retu
    }
  }

}

/*


Actions : 
Give 
Take 
 
Absorb 
Move 
 
Split 2 4  
Birth 10% 20% 30% 40% 
Merge 

GIVE(from,to){
	to.increaseEnergy( from.reduceEnergy(1) );
} 
TAKE(from,to){
	to.increaseEnergy( from.reduceEnergy(1) );
}
ABSORB(target){
	target.increaseEnergy(1);
}
MOVE(target,world){
	position = target.decideMoveTo(World);
  World.moveEntityTo(target);
}
SPLIT(target,segmenets){
	spaces = World->adjacents(target->position)->unoccupied()
  if(spaces->count() >= (segments-1) ){
  	$energy = $target->energy();
    $energy_chunk = $energy/$segments;
    foreach($spaces as $space){
    	$newEntity = Spawner::create($target->getGenome(),$energy_chunk);
      World->placeAt($space,$newEntity);
    }
  }
}
BIRTH(target)
MERGE(from,to)


If States:  

Self.energy | =,=>,>,<=,< | integer
Self.alive | = | true
Self.lastAction 

Neighbour = Neighbours.random,Neighbours.first,Neighbours.last

Neighbour.energy | =,=>,>,<=,< | integer
Neighbour.alive | = | true,false 
Neighbour.lastAction 

Neighbours.count 1-8 
Neighbours.pattern x +

Neighbour = Neighbours.getAt(1-8)
Neighbour = Neighbours.getRandom
Neighbour = Neigbours.getAdjacent
Neighbour = Neigbours.getFirst


Condition :
target
function
operator
value
 
 
 
If and or 
If multi clauses 
Multi cases 
Entity has x case/behaviour slots 
Each behaviour slot contains condition then action 

condition( based on self/neighbour/neigbours )
action subject( self/neighbour/condition_target(s) )
action

problems: many condition targets
- many conditions
- condition on neighbours

-behaviour rule for selecting condition target (random,1,2,3)

keyForConditionTargetSelection(){
	if(many conditions){
    	return $this->keyForConditionTargetSelection;
    }else{
    	return 1;
    }
}
getConditionTarget(){

	$key = $this->keyForConditionTargetSelection()
    $condition = $this->conditions->get($key);
    $targets = $condiotion->getTarget();
    if($targets is a entity){
    	return $targets;
    }else{
    	return pickEntity($targets);
    }
    
}

*/

class World{
  
  $positions;
  $entities;
  
  public function __construct($width,$height){}
  
  public function placeAt(Position $pos, Entity $entity){}
  
  public function getEntities(){ return $this->entities;}
  public function getNeighboursOf(Position $pos){ return $this->entities;}
  
  public function getPositions(){return $this->positions;}
  public function getAdjacentPositionsOf(Position $pos){}
}

       
abstract class Collection{
  
	public function set($key,$value);
	public function push($value);
	public function get($key);
	public function has($key);
  public function getFirst();
  public function getLast();
  public function getRandom();
  public function count();
}
class NeigbourCollection{
	public function getAt($x,$y);
  public function inPattern($pattern);
	
}
class PositionCollection{
	public function getOccupants();
	public function getOccupied();
	public function getUnoccupied();
	public function getByCoords($x,$y);
	public function getAdjacentsOf($x,$y);
}
			 
			 
class God{
	protected $world;
  public function loadWorld(){}
  public function runWorldTick(){
  	
    $entities = $this->world->getEntities();
    foreach($entities as $e){
      if($e->decayed()){
        $this->World->removeEntity($e);
      }else{
      	$e->live();
      }
    }
    
  }
}
       
       
       
       
       
       
       
       
       
