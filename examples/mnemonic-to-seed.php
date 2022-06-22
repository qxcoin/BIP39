<?php

use QXCoin\BIP39\BIP39;

require('../vendor/autoload.php');

$mnemonic = 'soap fit diesel safe chicken trash cute detect crazy crime increase move certain square vapor';

$bip39 = new BIP39();

$seed = $bip39->mnemonicToSeed($mnemonic);
var_dump($seed);
