<?php

namespace App;
class Player
{

    private string $name;
    private int $age;
    private float $balance = 0;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function deposit(float $amount)
    {
        $this->balance += $amount;
    }

    public function withdraw(float $amount)
    {
        if ($amount > $this->balance) {
            return null;
        }
        $this->balance -= $amount;
    }


}