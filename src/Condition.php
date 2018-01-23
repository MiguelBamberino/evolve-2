<?php

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
