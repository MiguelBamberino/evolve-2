<?php
namespace evolve\World;

interface class Action {
  
  function perform(Entity $e, World $w);
}