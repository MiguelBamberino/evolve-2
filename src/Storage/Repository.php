<?php

namespace evolve\Storage;
use evolve\Exceptions\ResourceNotFoundException;
use evolve\World;
use evolve\Collections\Collection;

class Repository{

    public function __construct($root_path){
        $this->root_path = $root_path;
    }
    ######### READERS #################################
    public function getWorldList(){
        return $this->parseResourceDir('');
    }
    public function worldExists($name){
        return file_exists( $this->root_path.'/'.$name );
    }
    public function getWorld($name){
        if($this->worldExists($name)){
            
            $data = $this->readIn($name.'/world');
            $world = new World($data->name,$data->width,$data->height,$data->current_tick);
            return $world;
        }else{
            throw new ResourceNotFoundException($name);
        }
    }
    public function getAllWorlds(){
        $collection = new Collection();
        $list = $this->getWorldList();
        foreach($list as $name){
            $world = $this->getWorld($name);
            $collection->set($name,$world);
        }
        return $collection;
    }
    ######## WRITERS ###############################
    public function createWorld($world){
        
        if($this->worldExists($world->name())){
            throw new \Exception("World : ".$world->name()." already exists.");
        }else{
            mkdir($this->root_path."/".$world->name());
            mkdir($this->root_path."/".$world->name()."/ticks");
            $data = array();
            $data['name'] = $world->name();
            $data['width'] = $world->width();
            $data['height'] = $world->height();
            $data['current_tick'] = $world->current_tick();

            var_dump(json_encode($data));
            file_put_contents($this->root_path. '/'.$world->name().'/world.json',json_encode($data));
        }
    }
    public function updateWorld($world){
        
    }
    public function deleteWorld($ref){
        
    }
    public function commitTick($world){
        
    }
    public function loadWorld($ref){
        
    }
    public function loadWorldFromTick($world_ref,$tick){
        
    }

    ############# INTERNALS ########################################
        private function parseResourceDir($dir){
        $resources = array();
        $dir_path = $this->root_path.'/'.$dir;
        if(file_exists($dir_path)){
            $items = scandir($dir_path);
            foreach($items as $item){
                if( !in_array($item,array('.','..')) && strpos($item,'.json')===false ){
                    $resources[$item]=$item;
                }
            }
        }else{
            throw new ResourceNotFoundException($dir);
        }
        return $resources;
    }
    private function writeOut($resource,$contents){
        return $this->_writeToFile(json_encode($contents));
    }
    private function _writeToFile($resource,$contents){
        $file_path = $this->root_path . '/'.$resource.".json";
        if(file_exists($file_path)){
            return file_put_contents($file_path,$contents);
        }else{
            throw new ResourceNotFoundException($resource.".json");
        } 
    }
    private function readIn($resource){
        return json_decode( $this->_readInFile($resource) );
    }
    private function _readInFile($resource){
        $file_path = $this->root_path . '/'.$resource.".json";
        if(file_exists($file_path)){
            return file_get_contents($file_path);
        }else{
            throw new ResourceNotFoundException($resource.".json");
        }
    }
}