<?php

declare(strict_types=1);

use HetznerCloud\HetznerCloud;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

/** @var string $apiKey */
$apiKey = $_ENV['HETZNER_CLOUD_API_KEY'];
$client = HetznerCloud::client($apiKey);

// Get a list of firewalls
$firewalls = $client->firewalls()->getFirewalls(name: 'coolify');
var_dump($firewalls);

// Get a single firewall
$firewall = $client->firewalls()->getFirewall($firewalls->firewalls[0]->id);
var_dump($firewall);
