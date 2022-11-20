<?php

namespace App;
class Game
{
    private array $symbols = [5.0 => '7', 4.0 => '6', 3.0 => '5', 2.0 => '2', 1.0 => '1'];
    private int $bet;
    private int $lineCount;

    private array $display = [
        [' ', ' ', ' ', ' ', ' '],
        [' ', ' ', ' ', ' ', ' '],
        [' ', ' ', ' ', ' ', ' ']
    ];

    private array $threeLineCombo = [
        //horizontal lines
        [[0, 0], [0, 1], [0, 2], [0, 3], [0, 4]],
        [[1, 0], [1, 1], [1, 2], [1, 3], [1, 4]],
        [[2, 0], [2, 1], [2, 2], [2, 3], [2, 4]]
    ];

    private array $fiveLineCombo = [
        [[0, 0], [1, 1], [2, 2], [1, 3], [0, 4]],
        [[2, 0], [1, 1], [0, 2], [1, 3], [2, 4]],
    ];

    private array $halfCombo = [
        //horizontal lines
        [[0, 0], [0, 1], [0, 2]],
        [[1, 0], [1, 1], [1, 2]],
        [[2, 0], [2, 1], [2, 2]],

        //  cross lines
        [[0, 0], [1, 1], [2, 2]],
        [[2, 0], [1, 1], [0, 2]]
    ];


    public function __construct(int $bet = 10, int $lineCount = 3)
    {

        $this->bet = $bet;
        $this->lineCount = $lineCount;
    }


    public function showDisplay(): string
    {
        $display = '';
        foreach ($this->display as $line) {
            foreach ($line as $element) {
                $display .= " | " . $element;
            }
            $display .= "\n";
        }
        return $display;
    }

    public function getLineCount(): int
    {
        return $this->lineCount;
    }

    public function getBet(): int
    {
        return $this->bet;
    }

    public function spin()
    {
        for ($i = 0; $i <= sizeof($this->display) - 1; $i++) {
            for ($j = 0; $j <= sizeof($this->display[$i]) - 1; $j++) {
                $this->display[$i][$j] = $this->symbols[array_rand($this->symbols)];
            }
        }
    }

    public function setBet(int $bet)
    {
        $this->bet = $bet;
    }

    public function setLineCount(int $line)
    {
        if ($line === 3 || $line === 5) {
            $this->lineCount = $line;
        }
    }


    public function countWinAmount(): int
    {
        $multiplier = 0;
        //for 3 line combos
        foreach ($this->symbols as $symbol) {
            foreach ($this->threeLineCombo as $combination) {
                $totalComboThree = 0;
                foreach ($combination as $position) {
                    [$x, $y] = $position;
                    if ($this->display[$x][$y] === $symbol)
                        $totalComboThree++;
                }
                if ($totalComboThree === 5) {
                    $multiplier += array_search($symbol, $this->symbols);
                } elseif ($totalComboThree === 4) {
                    $multiplier += array_search($symbol, $this->symbols) / 1.75;
                } elseif ($totalComboThree === 3) {
                    $multiplier += array_search($symbol, $this->symbols) / 2;
                }
            }
        }
        //active for 5 lines combination
        if ($this->lineCount === 5) {
            foreach ($this->symbols as $symbol) {
                foreach ($this->fiveLineCombo as $combination) {
                    $totalComboFive = 0;
                    foreach ($combination as $position) {
                        [$x, $y] = $position;
                        if ($this->display[$x][$y] === $symbol)
                            $totalComboFive++;
                    }
                    if ($totalComboFive === 5) {
                        $multiplier += array_search($symbol, $this->symbols);
                    } elseif ($totalComboThree === 4) {
                        $multiplier += array_search($symbol, $this->symbols) / 1.75;
                    } elseif ($totalComboThree === 3) {
                        $multiplier += array_search($symbol, $this->symbols) / 2;
                    }
                }
            }
        }
        return $this->bet * $multiplier;
    }

}