<?php

/*



Actions : 
Give 
Take 
 
Absorb 
Move 
 
Split 2 4  
Birth 10% 20% 30% 40% 
Merge 

Attr :
- action name (give,move,birth)
- config of action (birth10,split2,moveLeft)
- config of target type (conditions[x]->target,first_neigbhour,last_neighbour,rand_neighbour,all_neighbour)

do:
  - world
  - subject/entity
  - conditions
  
how to pick target, what if target is collection ? rand ?



--------- SAMPLE IMPLEMENTATION ------

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


*/