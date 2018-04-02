<?php
namespace evolve\World;

interface  Action {
  
  function __construct($how=null);
  function perform(Entity $e, World $w, Condition $c);
}