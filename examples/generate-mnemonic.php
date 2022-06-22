<?php

use Qxcoin\BIP39\BIP39;

require('../vendor/autoload.php');

$bip39 = new BIP39();

$entropySize = 128;
$mnemonic = $bip39->generateMnemonic($entropySize);
var_dump($mnemonic);
