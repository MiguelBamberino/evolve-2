<?php
namespace evolve\World;
class Entity{

    const ALIVE=1;
    const DEAD=2;
    const DECAYED=3;
    const DECAY_VAL=-50;

    protected $energy;
    protected $state;
    protected $position;
    protected $lastAction;
    
     /**
     * @test EntityTest::testBasicConstruction
     * @param Position $pos -> where there entity currently exists in the world
     * @param int $energy -> the life force within entity
     * @return integer $energy
     */
    public function __construct(Position $pos ,$energy ){
  	    $this->position = $pos;
        
        $this->energy = $energy;
        $this->checkState();
    }
  	
    protected $behaviours = array(
      /*  0=>array(
            'conditions'=>array(
                array('target'=>'SELF|'),
            ),
            'action'=>array(),
        )
    */
    );

    public function act(){
      
      $this->checkState();
      if($this->alive()){
          $this->decideBehaviour();
      }
    }
  
    protected function decideBehaviour(){


      foreach($this->behaviours as $behaviour){

        if($behaviour->perform($this)){
          return true;
        }
      }
    return false;
    }
    /**
     * reduce the energy of the entity and check for a state change
     * @test testEntity::testReduceEnergy
     * @param int $amount -> energy to add to entity
     * @return void
     */
    public function reduceEnergy($amount){
        $this->energy -= $amount;
        $this->checkState();
        if($this->decayed()){
            return $amount - ( self::DECAY_VAL - $this->energy );
        }else{
            return $amount;
        }
    }
    /**
     * Increase the energy of the entity and check for a state change
     * @test testEntity::testIncreaseEnergy
     * @param int $amount -> energy to add to entity
     * @return void
     */
    public function increaseEnergy($amount){
        $this->energy += $amount;
        $this->checkState();
    }
    /**
     * re-evaluate energy, to see if the entity changes state 
     * @test testEntity::constructionStateProvider
     * @return void 
     */
    private function checkState(){

        if( $this->decayed() == false ){   
            if($this->energy <= self::DECAY_VAL){       
                $this->state = self::DECAYED;
                if($this->position instanceof Position){
                  $this->position->clear(); // leave current
                }
                $this->position=null; // remove from world
            }else if($this->energy <= 0){       
                $this->state = self::DEAD;
            }else{
                $this->state = self::ALIVE;
            }     
        }
    }
    /**
     * is the entity alive 
     * @test testEntity::constructionStateProvider
     * @return boolean 
     */
    public function alive(){ 
        return ($this->state==self::ALIVE); 
    }
    /**
     * is the entity dead 
     * @test testEntity::constructionStateProvider
     * @return boolean 
     */
    public function dead(){ 
        return ($this->state==self::DEAD); 
    }
    /**
     * has the entity decayed 
     * @test testEntity::constructionStateProvider
     * @return boolean 
     */
    public function decayed(){ 
        return ($this->state==self::DECAYED); 
    }
    /**
     * @test EntityTest::testBasicConstruction
     * @return integer $energy
     */
    public function energy(){ return $this->energy; }
    /**
     * @test EntityTest::testBasicConstruction
     * @return Position $pos
     */
    public function position(){ return $this->position; }
    /** 
     * place the entity in a new world position, clearing
     * old world position
     * @test EntityTest::testCanPlaceAt
     * @test EntityTest::testCantPlaceAt
     * @param Position $target -> where to place entity 
     * @return boolean success
     */
    public function placeAt(Position $target){
        
        if($target->place($this) == false){
            return false;
        }else{
            $this->position->clear(); // leave current
            $this->position=$target; // move to target
            return true;
        }
          
    }
    
    public function behaviours(){ return $this->behaviours; }
  	
}
