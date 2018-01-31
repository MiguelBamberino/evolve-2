<?php

namespace evolve\Collections;
abstract class AbstractCollection extends \arrayIterator{
    
    /** 
     * @param string|int $key -> the look up ref in the collection
     * @param mixed $value -> the value to place at the lookup location
     */
    public function set($key,$value){
        $this->offsetSet($key, $value);
    }
    /**
     * @param mixed $value the value to push onto the collection
     */
	public function push($value){
        $this->append($value);
    }
	/**
     * @param string|int $key -> the key to look up
     * @return mixed|false value or false if not set
     */
    public function get($key){
        if($this->has($key)) {
            return $this->offsetGet($key);
        } else {
            return false;
        }
    }
    /**
     * @param string|int $key -> the key to look up
     * @return boolean -> does it exist or not
     */
    public function has($key){
        return $this->offsetExists($key);
    }
    /**
     * @return mixed -> the first item in the collection
     */
    public function getFirst(){
        foreach($this as $item){
            return $item;
        }
    }
    /**
     * @return mixed -> the last item in the collection
     */
    public function getLast(){
        return end($this);
        /*$found = false;
        foreach($this as $item){
            $found = $item;
        }
        return $found;*/
    }
    /**
     * @return mixed $item -> return a random item in collection
     */
    public function getRandom(){
        $pointer = rand(1,$this->count());
        $i=1;
        foreach($this as $item){
            if($pointer == $i){
                return $item;
            }
            $i++;
        }
    }
}