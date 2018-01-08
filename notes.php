<?php

/*

Cell World:
The world is made up of a 100x100 grid
each grid cell is a world position
each position may contain 1 or 0 entities

an entity has state:{energy,position,state(ALIVE|DEAD|DECAYED)}
an entity have a function for life
an entity has 1-many behaviour routines
given an entity is alive then it will select a behaviour to carry out
a behaviour is made up of a condition and action to carry out, given the condition is true
an entity will only carry out 1 behaviour per tick

a tick represents a moment in the world 
every tick every entity performs its function for life 

*/
class entity{

    const ALIVE=1;
    const DEAD=2;
    const DECAYED=3;
    const DECAY_VAL=-50;

    protected $energy;
    protected $state;
    protected $position;
    protected $lastAction;
    
    protected $behaviours = array(
    
    
    );

    public function live(){

        // re-evaluate current state
       // $this->chooseBehaviour();

    }
    public function removeEnergy($amount){
        $this->energy -= $amount;
        $this->checkState();
        if($this->decayed()){
            return $amount - ( self::DECAY_VAL - $this->energy );
        }else{
            return $amount
        }
    }
    public function increaseEnergy($amount){
        $this->energy += $amount;
        $this->checkState();
    }
    private function checkState(){

        if($this->alive()){   
            if($this->energy < self::DECAY_VAL){       
                $this->state = self::DECAYED;      
            }else if($this->energy < 0){       
                $this->state = self::DEAD;        
            }     
        }
    }
    public function alive(){ return ($this->state==self::ALIVE) }
    public function dead(){ return ($this->state==self::DEAD) }
    public function decayed(){ return ($this->state==self::DECAYED) }
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

If States:  
Self.energy 
Self.alive 
Self.exists 
Self.lastAction 

Neighbor.energy 
Neighbour.alive 
Neighbour.exist 
Neighbour.count 1-8 
Neighbour.pattern x +  

 
If and or 
If multi clauses 
Multi cases 
Entity has x case/behaviour slots 
Each behaviour slot contains condition then action 



*/