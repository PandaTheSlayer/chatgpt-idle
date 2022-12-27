<?php

declare(strict_types=1);

namespace MyProject\Model;

use MyProject\Model\Player;
use MyProject\Model\Upgrades;
use Symfony\Component\Console\Application;
use Tui\Tui;
use Tui\Widgets\Text;
use Tui\Widgets\Input;
use Tui\Widgets\Choice;
use Tui\Widgets\Spinner;

class Game
{
    private Player $player;
    private Application $tui;
    private Upgrades $upgrades;

    public function __construct(Player $player, Application $tui, Upgrades $upgrades)
    {
        $this->player = $player;
        $this->tui = $tui;
        $this->upgrades = $upgrades;
    }

    public function play(): void
    {
        while (true) {
            $this->tui->
            $this->tui->clear();
            $this->tui->add(new Text("Coins: {$this->player->coinCount}"));
            $this->tui->add(new Text("Coin rate: {$this->player->coinRate} coins/second"));
            $this->tui->add(new Text("Upgrades:"));
            $upgradeNames = $this->upgrades->listUpgrades();
            foreach ($upgradeNames as $upgradeName) {
                $cost = $this->upgrades->getUpgradeCost($upgradeName);
                $this->tui->add(new Text("- $upgradeName: $cost coins"));
            }
            $this->tui->add(new Input('Enter upgrade name to buy:'));
            $result = $this->tui->listen();
            if ($result === null) {
                break;
            }
            $this->upgrades->buyUpgrade($result, $this->player);
        }
    }
}