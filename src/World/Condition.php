<?php
namespace evolve\World;

class Condition{
    
    const SELF = 100;
    const NEIGBOUR = 200;
    const NEIGHBOURS = 300;
    
    protected $target_ref;
    protected $method;
    protected $operator;
    protected $value;
    
	/**
	 * Construct a world condition evaluator 
     * @param const|int $target_ref -> the type of target, for the condition
     * @param string $method -> method on target object to call
     * @param string $operator -> which operator to use in evaluation
     * @param mixed $value -> what value should be expected against operator and method to evaluate true
     */
    public function __construct($target_ref, $method, $operator, $value ){
                
        $this->target_ref = $target_ref;
        $this->method = $method;
        $this->operator = $operator;
        $this->value = $value;
    }
    /**
     * retrieve the target object from world based on $target_ref
     */
    protected function getTargetObject(Entity $entity,World $world){
        switch($this->target_ref){
            case self::SELF :
                return $entity;
                break;
            case self::NEIGBOUR :
                return $this->world->neighboursOf($entity->position())->random();
                break;
            case sef::NEIGHBOURS :
                return $this->world->neighboursOf($entity->position());
                
        }
    }
    /**
     * Evaluate condition based on world and entity passed in
     * @param Entity $entity -> the object to use as the subject of evaluation
     * @param World $world -> the world to provide information to evaluate subject
     */
    public function evaluate(Entity $entity, World $world ){
        
      $target_object = $this->getTargetObject($entity,$world);
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
