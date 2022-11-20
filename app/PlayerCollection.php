<?php

namespace App;

class PlayerCollection
{
    private array $PlayerCollection = [];

    public function addPlayer(Player $player)
    {
        $this->PlayerCollection[$player->getName()] = $player;
    }

    public function getPLayerBalance($name): float
    {
        return $this->PlayerCollection[$name]->getBalance();
    }


}