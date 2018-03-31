<?php
include __DIR__."/vendor/autoload.php";

use evolve\World\World;
use evolve\World\Position;
use evolve\World\Entity;
use evolve\World\Condition;
use evolve\Collections\Collection;
use evolve\Collections\EntityCollection;

$cond = new Condition(Condition::SELF,"decayed",'=',  true);


$repo = new evolve\Storage\Repository('./tests/data/state0/worlds/');

$pos = new Position(2,3);
$pos2 = new Position(4,6);
$entities = new EntityCollection();
$entities->push( new Entity($pos,23) );
$entities->push( new Entity($pos2,33) );

$world = new World('alpharia',10,10,1,$entities);

renderWorld($world);

$e = $world->getEntities()->getFirst();
$e->reduceEnergy(200);
var_dump( $cond->evaluate( $e , $world ) );

$world->tickover();
renderWorld($world);

exit;





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

function renderWorld($world){
  
  print "\n\n";
  print "Tick:".$world->current_tick();
  print "\n\n";

  $cy = 0;

  foreach($world->getPositions() as $pos){

    if($pos->y() != $cy){
      print "\n";
    }

      if($pos->occupied()){
        print "#";
      }else{
        print ".";
      }
    $cy = $pos->y();
  }
  print "\n\n";

}