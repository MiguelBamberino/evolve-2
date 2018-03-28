<?php

/*
data storage :

Per Tick:
- tick number
- position and energy of all entities

Per world:
- world size
- world name
- current tick
- entities:foreach:
	- geneology string
	- position
	- energy
	- behaviours (could be derrived from geneology)
	- icon/image (could be derrived from geneology)
	- parent(s) (could be derrived from geneology)
	
	idea 1 snapshot:
	/universe
		/world1/
			/...
		/world2/
			/...
		/world3/
			/1
				/tick.json
			/2
				/tick.json
				
	+ simple for streaming ticks
	+ easy to load world view in one file
	- harder to read information across ticks/time
	- duplication of data, most data is static on creation instead of mutable
	
	idea 2 normalised (mongoDB,MySQL,memcache,filesystem):
	* worlds.json -> world:{name:'terra',ticks:34,width:100:height:100}
  * entities.json -> entity:{geneology:'dFaGgSe',x:23,y:56,energy:100,world_id:1,parents:45}	
	* ticks.json -> tick:{tick,world_id,entity_id,x:,y,energy}
	
	+ normalised so cross tick queries are easy
	+ more flexibility for data retrieval 
	- bit more complicated to build
	- bit more complicated to construct data
	
	- world
			- tick_entity_state
			- entities
				- tick_entity_state
	
	maybe an interface for reading and writing so can change storage solution 
	interface :
	
	getWorld($world_ref) //w entities
	
	getAllWorlds()
	
	updateWorld($world)
		
	commitTick($world) 
		// excluding entities that have decayed
		// if tick state already on store exists then reject
		// create new tick states
		// add New Entities that spawned this tick
		
	loadWorld($world_ref)
		$world = getWorld($world_ref)
		$tick_states = getTickStates($world->current_tick)
		$entities = build
		
	LoadWorldFromTick($world_ref,$tick)


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
  
	$name;
	$width;
	$height;
	$ticks;
  $positions;
  $entities;
  
  public function __construct($name,$width,$height,$ticks,$entities){}
  
	public function tickOver(){}
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
       
       
       
       
       
       
       
       
       
