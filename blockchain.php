<?php
require 'vendor/autoload.php';

use Web3\Web3;
use Web3\Contract;
use Web3\Utils;

class BlockchainLogger {
    private $web3;
    private $walletAddress;

    public function __construct() {
        $infuraUrl = "https://mainnet.infura.io/v3/24d471be2a174bc3a0ea006949bbcc8e";
        $this->web3 = new Web3($infuraUrl);
        $this->walletAddress = "0x32Cc6c3F8352f02b0554642BFfB3404628fE0ab3";
    }

    public function logEvent($message) {
        $hashedMessage = Utils::sha3($message);
        $timestamp = time();
        $logData = json_encode([
            "hash" => $hashedMessage,
            "timestamp" => $timestamp
        ]);
        
        // Guardar localmente (opcional)
        file_put_contents("logs.json", $logData . PHP_EOL, FILE_APPEND);
        
        return $hashedMessage;
    }
}
?>
