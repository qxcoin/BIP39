<?php

namespace Qxcoin\BIP39\Wordlists;

interface WordlistInterface
{
    public function getWords(): array;
    public function getWord(int $index): ?string;
}
