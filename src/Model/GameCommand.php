<?php

declare(strict_types=1);

namespace MyProject\Model;

use MyProject\SaveManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GameCommand extends Command
{
    protected static $defaultName = 'game';

    private Player $player;
    private Upgrades $upgrades;
    private SaveManager $saveManager;

    public function __construct(Player $player, Upgrades $upgrades)
    {
        parent::__construct();
        $this->player = $player;
        $this->upgrades = $upgrades;
        $this->saveManager = new SaveManager('save.json');
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Play the game')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $previousError = '';

        $this->saveManager->load($this->player, $this->upgrades);

        while (true) {
            passthru('clear');
            if ($previousError) {
                $io->error($previousError);
                $previousError = '';
            }

            $io->section('Current status');
            $io->writeln("Coins: {$this->player->coinCount}");
            $io->writeln("Coin rate: {$this->player->coinRate} coins/second");
            // Display a list of already bought upgrades
            $io->section('Bought upgrades');
            if (empty($this->upgrades->boughtUpgrades)) {
                $io->writeln('No bought upgrades');
            } else {
                foreach ($this->upgrades->boughtUpgrades as $name) {
                    $io->writeln($name);
                }
            }


            $io->section('Upgrades:');
            $upgradeNames = $this->upgrades->listUpgrades();
            foreach ($upgradeNames as $upgradeName) {
                $cost = $this->upgrades->getUpgradeCost($upgradeName);
                $io->text("- $upgradeName: $cost coins");
            }

            $action = $io->choice('Choose action:', ['Click', 'Buy upgrade', 'Exit'], 'Click');
            switch ($action) {
                case 'Click':
                    $this->player->addCoins($this->player->coinRate);
                    break;
                case 'Buy upgrade':
                    $upgradeName = $io->ask('Enter upgrade name to buy:');
                    try {
                        $this->upgrades->buyUpgrade($upgradeName, $this->player);
                    } catch (\Exception $e) {
                        $previousError = $e->getMessage();
                    }
                    break;
                case 'Exit':
                    $this->saveManager->save($this->player, $this->upgrades);
                    break 2;
            }
        }

        return 0;
    }
}
