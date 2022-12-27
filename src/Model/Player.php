<?php

declare(strict_types=1);

namespace MyProject\Model;

class Player
{
    public int $coinCount = 0;
    public int $coinRate = 1;

    public function addCoins(int $coins): void
    {
        $this->coinCount += $coins;
    }
}