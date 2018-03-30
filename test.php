<?php
include __DIR__."/vendor/autoload.php";

use evolve\Position;
use evolve\Entity;
use evolve\Collections\Collection;
use evolve\Collections\EntityCollection;


$repo = new evolve\Storage\Repository('./tests/data/state0/worlds/');

$pos = new Position(2,3);
$pos2 = new Position(3,3);
$entities = new EntityCollection();
$entities->push( new Entity($pos,100) );
$entities->push( new Entity($pos2,100) );

$world = new evolve\World('alpharia',10,10,1,$entities);

var_dump($world->getPositions()->count());
exit;
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