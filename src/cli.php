<?php

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\CliMenuBuilder;

require_once(__DIR__ . '/../vendor/autoload.php');

$itemCallable = function (CliMenu $menu) {
    echo $menu->getSelectedItem()->getText();
};

$menu = (new CliMenuBuilder)
    ->setTitle('Basic CLI Menu Styling')
    ->addItem('First Item', $itemCallable)
    ->addItem('Second Item', $itemCallable)
    ->addItem('Third Item', $itemCallable)
    ->setWidth(70)
    ->setBackgroundColour('yellow')
    ->setForegroundColour('black')
    ->setPadding(4)
    ->setMargin(4)
  ->setUnselectedMarker('❅')
    ->setSelectedMarker('>')
    //->setUnselectedMarker(' ')
    //->setSelectedMarker('>')
    ->setTitleSeparator('- ')
    ->build();

$menu->open();