<?php

declare(strict_types=1);

namespace MyProject\Model;

class Player
{
    public int $coinCount;
    public int $coinRate;

    public function __construct()
    {
        $this->coinCount = 0;
        $this->coinRate = 1;
    }
}