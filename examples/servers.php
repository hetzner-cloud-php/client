<?php

declare(strict_types=1);

use Carbon\Carbon;
use HetznerCloud\HetznerCloud;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

/** @var string $apiKey */
$apiKey = $_ENV['HETZNER_CLOUD_API_KEY'];
$client = HetznerCloud::client($apiKey);

// Create a server
$createdServer = $client->servers()->createServer([
    'name' => 'test-server',
    'server_type' => 'cpx11',
    'image' => 'ubuntu-24.04',
]);
var_dump($createdServer);

// Get a list of servers
$servers = $client->servers()->getServers();
var_dump($servers);

// Get a single server
$server = $client->servers()->getServer($createdServer->server->id);
var_dump($server);

$serverId = $server->server->id;
$updatedServer = $client->servers()->updateServer($serverId, [
    'name' => 'test-server-updated',
    'labels' => [
        'foo' => 'bar',
    ],
]);
var_dump($updatedServer);

$serverMetrics = $client->servers()->getServerMetrics(
    $serverId,
    ['disk', 'cpu'],
    Carbon::now()->subDays(),
    Carbon::now()
);
var_dump($serverMetrics);

$deletedServer = $client->servers()->deleteServer($serverId);
var_dump($deletedServer);
