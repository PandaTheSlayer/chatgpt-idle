<?php

declare(strict_types=1);

use MyProject\Model\GameCommand;
use MyProject\Model\Player;
use MyProject\Model\Upgrades;
use Symfony\Component\Console\Application;

require_once __DIR__.'/vendor/autoload.php';

$player = new Player();
$upgrades = new Upgrades();
$gameCommand = new GameCommand($player, $upgrades);

$application = new Application();
$application->add($gameCommand);
$application->setDefaultCommand($gameCommand->getName(), true);
$application->run();