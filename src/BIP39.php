<?php

namespace Qxcoin\BIP39;

use Qxcoin\BIP39\Wordlists\WordlistInterface;
use Qxcoin\BIP39\Wordlists\EnglishWordlist;
use InvalidArgumentException;

final class BIP39
{
    private WordlistInterface $wordlist;

    public function __construct(WordlistInterface $wordlist = null)
    {
        $this->wordlist = $wordlist ?? new EnglishWordlist();
    }

    public function mnemonicToSeed(string $mnemonic, string $passphrase = '')
    {
        return bin2hex(hash_pbkdf2("sha512", $mnemonic, "mnemonic" . $passphrase, 2048, 64, true));
    }

    public function entropyToMnemonic(string $entropy)
    {
        $checksumSize = strlen($entropy) / 32;
        $hex = str_pad(gmp_strval(gmp_init($entropy, 2), 16), strlen($entropy) / 8 * 2, "0", STR_PAD_LEFT);
        $hash = hash('sha256', hex2bin($hex));
        $checksum = substr(str_pad(gmp_strval(gmp_init($hash, 16), 2), 256, "0", STR_PAD_LEFT), 0, $checksumSize);
        $pieces = str_split($entropy . $checksum, 11);

        $words = [];
        foreach ($pieces as $piece) {
            $words[] = $this->wordlist->getWord(bindec($piece));
        }

        return implode(' ', $words);
    }

    public function generateMnemonic(int $entropySize = 128)
    {
        if ($entropySize < 128 or $entropySize > 256) {
            throw new InvalidArgumentException('Entropy size must be between 128-256.');
        } elseif ($entropySize % 32 !== 0) {
            throw new InvalidArgumentException('Entropy size must be generated in multiples of 32.');
        }

        $bytes = random_bytes($entropySize / 8);
        $entropy = str_pad(gmp_strval(gmp_init(bin2hex($bytes), 16), 2), $entropySize, '0', STR_PAD_LEFT);

        return $this->entropyToMnemonic($entropy);
    }
}
