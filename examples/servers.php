<?php

declare(strict_types=1);

use HetznerCloud\HetznerCloud;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

/** @var string $apiKey */
$apiKey = $_ENV['HETZNER_CLOUD_API_KEY'];
$client = HetznerCloud::client($apiKey);

// Get a list of servers
$servers = $client->servers()->getServers();
var_dump($servers);

// Get a single server
$server = $client->servers()->getServer($servers->servers[0]['id']);
var_dump($server);

// Create a server
$createdServer = $client->servers()->createServer(
    name: 'test-server',
    image: 'ubuntu-24.04',
    serverType: 'cpx11',
);
var_dump($server);
