<?php
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
 public function testBasicConstruction(){
   $pos = new evolve\Position(45,34);
   $this->assertEqual(79,$pos->x()+$pos->y());
 } 
}