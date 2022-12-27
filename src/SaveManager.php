<?php

declare(strict_types=1);

namespace MyProject;

use MyProject\Model\Player;
use MyProject\Model\Upgrades;

class SaveManager
{
    private $saveFile;

    public function __construct(string $saveFile)
    {
        $this->saveFile = $saveFile;
    }

    public function save(Player $player, Upgrades $upgrades): void
    {
        $data = [
            'player' => [
                'coinCount' => $player->coinCount,
                'coinRate' => $player->coinRate,
            ],
            'upgrades' => [
                'bought' => $upgrades->boughtUpgrades,
            ],
        ];

        file_put_contents($this->saveFile, json_encode($data));
    }

    public function load(Player $player, Upgrades $upgrades): void
    {
        if (!file_exists($this->saveFile)) {
            return;
        }

        $data = json_decode(file_get_contents($this->saveFile), true);

        $player->coinCount = $data['player']['coinCount'];
        $player->coinRate = $data['player']['coinRate'];
        $upgrades->boughtUpgrades = $data['upgrades']['bought'];
    }
}
