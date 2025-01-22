<?php

declare(strict_types=1);

use HetznerCloud\HetznerCloud;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

/** @var string $apiKey */
$apiKey = $_ENV['HETZNER_CLOUD_API_KEY'];
$client = HetznerCloud::client($apiKey);

// Get a list of datacenters
$datacenters = $client->datacenters()->getDatacenters();
var_dump($datacenters);

// Get a single datacenter
$datacenter = $client->datacenters()->getDatacenter($datacenters->datacenters[0]->id);
var_dump($datacenter);
