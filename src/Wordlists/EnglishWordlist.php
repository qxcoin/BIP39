<?php

namespace QXCoin\BIP39\Wordlists;

class EnglishWordlist implements WordlistInterface
{
    private array $words;

    public function __construct()
    {
        $this->words = file(__DIR__ . '/../../data/wordlists/english.txt', FILE_IGNORE_NEW_LINES);
    }

    public function getWords(): array
    {
        return $this->words;
    }

    public function getWord(int $index): ?string
    {
        return $this->words[$index] ?? null;
    }
}
