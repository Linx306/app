<?php
require 'vendor/autoload.php';

use Web3\Web3;
use Web3\Contract;
use Web3\Utils;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Personal;

class BlockchainLogger {
    private $web3;
    private $eth;
    private $personal;
    private $fromAddress;
    private $privateKey;

    public function __construct() {
        $infuraUrl = "https://mainnet.infura.io/v3/24d471be2a174bc3a0ea006949bbcc8e";
        $this->web3 = new Web3(new HttpProvider(new HttpRequestManager($infuraUrl, 10)));
        $this->eth = $this->web3->eth;
        $this->personal = new Personal($this->web3->provider);

        $this->fromAddress = "0x32Cc6c3F8352f02b0554642BFfB3404628fE0ab3";
        $this->privateKey = "9b94a8c979a0c26eb8afcfb7476599f393d5a3395eb8db50ab9f05682249f8c4";
    }

    public function logEvent($message) {
        $hashedMessage = Utils::sha3($message);
        $timestamp = time();

        $transaction = [
            'from' => $this->fromAddress,
            'to' => $this->fromAddress, // Puedes usar otro smart contract si quieres
            'value' => '0x0',
            'gas' => '0x5208',
            'gasPrice' => '0x3B9ACA00',
            'data' => '0x' . bin2hex($hashedMessage)
        ];

        $this->eth->sendTransaction($transaction, function ($err, $txHash) {
            if ($err !== null) {
                echo "Error al enviar la transacción: " . $err->getMessage();
                return;
            }
            echo "Registro en blockchain: " . $txHash;
        });

        return $hashedMessage;
    }
}
?>

