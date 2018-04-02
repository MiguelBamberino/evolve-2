<?php
namespace evolve\World\Actions;

use evolve\World\World;
use evolve\World\Position;
use evolve\World\Entity;
use evolve\World\Condition;

interface  iAction {
  
  function __construct($how=null);
  function perform(Entity $e, World $w, Condition $c);
}