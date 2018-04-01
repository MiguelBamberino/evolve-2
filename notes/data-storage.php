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
	
	getWorld($world_ref) 
		// retrieve a world object without entities
	
	getAllWorlds()
	 // retrieve all world objects, without entities.
	
	updateWorld($world)
	 // modify general world info
	 
	 deleteWorld($world_ref)
	  // remove a world and all its entities
	
		
	commitTick($world) 
		// excluding entities that have decayed
		// if tick state already on store exists then reject
		// create new tick states
		// add New Entities that spawned this tick
		
	loadWorld($world_ref)
	  // get a world and populate it ready to run the next tick
		$world = getWorld($world_ref)
		$tick_states = getTickStates($world->current_tick)
		$entities = build
		
	LoadWorldFromTick($world_ref,$tick)

*/