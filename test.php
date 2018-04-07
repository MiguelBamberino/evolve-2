<?php
include __DIR__."/vendor/autoload.php";

use evolve\World\Actions\MoveAction;
use evolve\World\Actions\AbsorbAction;
use evolve\World\Actions\TakeAction;
use evolve\World\Actions\GiveAction;
use evolve\World\Actions\SplitAction;

use evolve\World\World;
use evolve\World\Position;
use evolve\World\Entity;
use evolve\World\Condition;
use evolve\Collections\Collection;
use evolve\Collections\EntityCollection;

$repo = new evolve\Storage\Repository('./tests/data/state0/worlds/');


   # testAction();

runWorld(100);

exit;

function runWorld($ticks){
 $world = buildWorld();
  for($i=0;$i<=$ticks;$i++){
    renderWorld($world);
    testTickover($world);
  }
  
}

function testTickover($world){
  
  $lowE = new Condition(Condition::SELF,"energy",'<=',  20);
  $readyToSplit = new Condition(Condition::SELF,"energy",'>=',  20);
  $moveA = new MoveAction('RA');
  $absorbA = new AbsorbAction();
  $takeA = new TakeAction('first');
  $giveA = new GiveAction('first');
  $splitA = new SplitAction(2);
  foreach($world->getEntities() as $e){
    if($lowE->evaluate( $e , $world )){
      $ret = $absorbA->perform($e,$world,$lowE);
      continue;
    }
    if($readyToSplit->evaluate($e,$world)){
      $ret = $splitA->perform($e,$world,$readyToSplit);
      continue;
    }
    break;
  }
  $world->tickover();
  sleep(1);
  
}
function testAction(){
  
  $world = buildWorld();
  renderWorld($world,false);
    
  $cond = new Condition(Condition::SELF,"energy",'<=',  30);
  $moveA = new MoveAction('RA');
  $absorbA = new AbsorbAction();
  $takeA = new TakeAction('first');
  $giveA = new GiveAction('first');
  $splitA = new SplitAction(2);
  $e = $world->getEntities()->getFirst();
  $ret = $splitA->perform($e,$world,$cond);
  $world->tickover();
  sleep(1);
  renderWorld($world,false);
  
  
}

function buildWorld(){
   $pos = new Position(2,3);
  $pos2 = new Position(2,2);
  $entities = new EntityCollection();
  $entities->push( new Entity($pos,20) );
  $entities->push( new Entity($pos2,30) );

  return new World('alpharia',20,10,1,$entities);

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
function renderWorld($world,$refresh=true){
  if($refresh)system('clear');
  print "\n";
  print "\nKlioBytes:".memory_get_usage()/1024;
  print "\nTick:".$world->current_tick();
  print "\nHeight:".$world->height();
  print "\nWidth:".$world->width();
   foreach($world->getEntities() as $key=> $e){
    #$ret = $moveA->perform($e,$world,$cond);
     print " | E".$key." : ".$e->energy();
  }
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