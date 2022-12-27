<?php

require_once __DIR__ . '/vendor/autoload.php';

$player = new MyProject\Model\Player();
$tui = new Tui\Tui();
$upgrades = new MyProject\Model\Upgrades();

$game = new MyProject\Model\Game($player, $tui, $upgrades);
$game->play();
