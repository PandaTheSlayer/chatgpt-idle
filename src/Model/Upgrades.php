<?php

declare(strict_types=1);

namespace MyProject\Model;

class Upgrades
{
    private $upgradeSettings;

    public $boughtUpgrades = [];

    public function __construct()
    {
        $this->upgradeSettings = [
            'coin_rate' => [
                'cost' => 10,
                'callback' => function (Player &$player) {
                    $player->coinRate *= 2;
                },
            ],
            'autoclicker' => [
                'cost' => 20,
                'callback' => function (Player &$player) {
                    $player->coinCount += $player->coinRate;
                },
            ],
        ];
    }

    public function buyUpgrade(string $upgradeName, Player &$player): void
    {
        if (!isset($this->upgradeSettings[$upgradeName])) {
            echo "Invalid upgrade name.\n";
            return;
        }
        $upgrade = $this->upgradeSettings[$upgradeName];
        if ($player->coinCount < $upgrade['cost']) {
            throw new \Exception("You don't have enough coins to buy this upgrade.\n");
        }
        $upgrade['callback']($player);
        $player->coinCount -= $upgrade['cost'];
        $this->boughtUpgrades[] = $upgradeName;
    }

    public function listUpgrades(): array
    {
        return array_keys($this->upgradeSettings);
    }

    public function getUpgradeCost(string $upgradeName): int
    {
        if (!isset($this->upgradeSettings[$upgradeName])) {
            throw new \InvalidArgumentException("Invalid upgrade name.");
        }
        return $this->upgradeSettings[$upgradeName]['cost'];
    }
}
