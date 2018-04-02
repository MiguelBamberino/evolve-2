<?php
include __DIR__."/vendor/autoload.php";

use evolve\World\World;
use evolve\World\MoveAction;
use evolve\World\Position;
use evolve\World\Entity;
use evolve\World\Condition;
use evolve\Collections\Collection;
use evolve\Collections\EntityCollection;

$repo = new evolve\Storage\Repository('./tests/data/state0/worlds/');



runWorld(4);

exit;

function runWorld($ticks){
  $pos = new Position(2,3);
  $pos2 = new Position(4,6);
  $entities = new EntityCollection();
  $entities->push( new Entity($pos,23) );
  $entities->push( new Entity($pos2,33) );

  $world = new World('alpharia',10,10,1,$entities);

    renderWorld($world);
    testTickover($world);
  }
  
}

function testTickover($world){
  
  $cond = new Condition(Condition::SELF,"decayed",'=',  true);
  $moveA = new MoveAction('RA');
  foreach($world->getEntities() as $e){
    $ret = $moveA->perform($e,$world,$cond);
  }
  #$e->reduceEnergy(200);
  #var_dump($ret);
  #var_dump( $cond->evaluate( $e , $world ) );
  $world->tickover();
  sleep(1);
  
}



foreach($world->getPositions() as $pos){
    var_dump($pos->x().','.$pos->y());
}



$repo->createWorld($world);

$ret = $repo->getWorld('alpharia');
var_dump($ret->name());
exit;
var_dump($world->name());
$data = array();
$data['name'] = $world->name();
$data['width'] = $world->width();
$data['height'] = $world->height();
$data['current_tick'] = $world->current_tick();

var_dump(json_encode($data));
file_put_contents('./tests/data/state0/worlds/terra/world.json',json_encode($data));

var_dump($repo->getWorldList());
$ret = $repo->getWorld('narnia');
var_dump($ret->name());
$worlds = $repo->getAllWorlds();
foreach($worlds as $w){
  var_dump($w->name());
  var_dump($w->width().'x'.$w->height());
}
#var_dump($ret);
function printAxis($number){
  if($number>9){
    print $number." |";
  }else{
    print " ".$number." |";
  }
}
function renderWorld($world){
  system('clear');
  print "\n\n";
  print "Tick:".$world->current_tick();
  print "Height:".$world->height();
  print "Width:".$world->width();
  print "\n\n";

  $height = $world->height();
  $width = $world->width();
  $grid = $world->getPositions();
  for($h = $height; $h>0;$h--){
     printAxis($h);
     for($w=1;$w<=$width;$w++){
       $pos = $grid->getByCoords($w,$h);
       if($pos instanceof Position){
         
       }else{
         var_dump($w.",".$h);
         var_dump($pos);
       }
       if($pos->occupied()){
         print "#";
       }else{
         print " ";
       }
       print"|";
     }
     print "\n";
     print "---|";
     for($w=1;$w<=$width;$w++){
        print "--";  
     }
     print "\n";
    
  }
  print" 0 |";
  for($w=1;$w<=$width;$w++){
     print($w."|");
    
  }
  print "\n";
  

}