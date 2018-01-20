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

        if( $this->decayed() == false ){   
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
    public function position(){ return $this->position; }
    public function setPosition(Position $pos){ return $this->position=$pos; }
    public function behaviours(){ return $this->behaviours; }
  	
}
