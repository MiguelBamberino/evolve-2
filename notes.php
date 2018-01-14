<?php

/*

*/
class Entity{

    const ALIVE=1;
    const DEAD=2;
    const DECAYED=3;
    const DECAY_VAL=-50;

    protected $energy;
    protected $state;
    protected $position;
    protected $lastAction;
    
  public function __construct(Position $pos ,$energy ){
  	$this->position = $pos;
    $this->energy = $energy;
  }
  	
    protected $behaviours = array(
        0=>array(
            'conditions'=>array(
                array('target'=>'SELF|'),
            ),
            'action'=>array(),
        )
    
    );

    public function live(){

        // re-evaluate current state
       // $this->chooseBehaviour();

    }
    public function reduceEnergy($amount){
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
    public function energy(){ return $this->energy; }
  	
  protected function giveEnergy(Entity $recipient){} 
  protected function takeEnergy(Entity $victim){} 
  protected function absorbEnergy(){} 
  protected function moveTo(Position $newPosition){} 
  
  protected function split($parts){}
  protected function birth($perc){}
  protected function merge(Entity $entity){}
  	
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

Self.energy | =,=>,>,<=,< | integer
Self.alive | = | true
Self.lastAction 

Neighbour = Neighbours.random,Neighbours.first,Neighbours.last

Neighbour.energy | =,=>,>,<=,< | integer
Neighbour.alive | = | true,false 
Neighbour.lastAction 

Neighbours.count 1-8 
Neighbours.pattern x +  


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

*/
class Position{
  protected $x;
  protected $y;
  
  public function __construct($x,$y){
    $this->x = $x;
    $this->y = $y;
  }
  public function x(){
  	return $this->x;
  }
  public function y(){
  	return $this->y;
  }
}
class Condition{
    
    protected $world;
    
    protected $target;
    protected $method;
    protected $operator;
    protected $value;
    
    public function __construct($world, $target, $method, $operator, $value ){
        
        $this->world = $world;
        
        $this->target = $target;
        $this->method = $method;
        $this->operator = $operator;
        $this->value = $value;
    }
    
    protected function getTargetObject($position){
        switch($this->target){
            case 'self':
                return $this->world->getEntityAt($position);
                break;
            case 'neighbour':
                return $this->world->neighboursOf($position)->random();
                break;
            case 'neighbours':
                return $this->world->neighboursOf($position);
                
        }
    }
    
    public function evaluate(Position $position){
        
      $target_object = $this->getTargetObject($position);
      if(!$target_object){
		return false;
      }
      $target_value = call_user_func(array($target_object, $this->method));
      
        switch($this->operator){
            case '=':
                return ($target_value == $this->value);
                break;
            case '>':
                return ($target_value > $this->value);
                break;
            case '>=':
                return ($target_value >= $this->value);
                break;
            case '<':
                return ($target_value < $this->value);
                break;
            case '<=':
                return ($target_value <= $this->value);
                break;
        }
    }
}





