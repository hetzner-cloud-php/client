<div align="center" style="padding-top: 2rem;">
    <img src="assets/sample.svg" height="500" width="600" alt="logo"/>
    <div style="display: inline-block; padding-top: 2rem">
        <img src="https://img.shields.io/packagist/v/hetzner-cloud-php/client.svg?style=flat-square" alt="packgist downloads" />
        <img src="https://img.shields.io/github/actions/workflow/status/hetzner-cloud-php/client/run-tests.yml?branch=main&label=tests&style=flat-square" alt="tests ci" />
        <img src="https://img.shields.io/github/actions/workflow/status/hetzner-cloud-php/client/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square" alt="packgist downloads" />
        <img src="https://img.shields.io/packagist/dt/hetzner-cloud-php/client.svg?style=flat-square" alt="packgist downloads" />
    </div>
</div>

## Hetzner Cloud PHP

A PHP client for the Hetzner Cloud API. The goal of this project is to provide an easy-to-use and framework agnostic PHP
PHP client for projects and applications interacting with Hetzner Cloud. Some use cases might include:

- Getting metrics for all servers within a project
- Programmatically creating firewalls
- Searching for available datacenters

## Table of Contents

- [Getting started](#getting-started)
- [Usage](#usage)
    - [Database](#database)
    - [Firewalls](#firewalls)
    - [Servers](#servers)

## Getting started

The client is available as a composer packager that can be installed in any project using composer:

```bash
composer require hetzner-cloud-php/client
```

Since the client is compatible with any PSR-18 HTTP client, any commonly used HTTP client can be used thanks
to our dependency on `php-http/discovery`. Once both dependencies have been installed, you may start interaction
with [Hetzner Cloud API](https://docs.hetzner.cloud/):

```php
/** @var string $apiKey */
$apiKey = $_ENV['HETZNER_CLOUD_API_KEY'];
$client = HetznerCloud::client($apiKey);

// Create a server
$response = $createdServer = $client->servers()->createServer([
    'name' => 'test-server',
    'server_type' => 'cpx11',
    'image' => 'ubuntu-24.04',
]);

echo $response->server->name; // 'test-server'
```

For a comprehensive set of examples, take a look at the [examples](/examples) directory.

## Usage

### Datacenters

#### Get all datacenters

Gets a list of available datacenters.

```php
$response = $client->datacenters()->getDatacenters(sort: 'name:desc');

echo $response->datacenters // array<int, Datacenter>
echo $response->meta // Meta::class
echo $response->toArray() // ['datacenter' => ['id' => 42, ...], 'meta' => [...]]
```

#### Get a datacenter

Gets a single datacenter.

```php
$response = $client->datacenters()->getDatacenter(42);

echo $response->datacenter // Datacenter::class
echo $response->toArray() // ['datacenter' => ['id' => 42, ...], 'error' => null]
```

### `Firewalls`

#### Get a firewall

Retrieves a single firewall for a project.

```php
$response = $client->firewalls()->getFirewall(1337);
$response->firewall; // Firewall::class
$response->toArray(); // ['firewall' => ['id => 1337', ...]]
```

#### Get firewalls

Retrieves all firewalls for a project, with a few optional query parameters.

```php
$response = $client->firewalls()->getFirewalls(name: 'coolify', labelSelector: 'foo');
$response->firewalls; // array<int, Firewall::class>

foreach ($response->firewalls as $firewall) {
    $firewall->id;
    $firewall->name;
    // ...
}

$response->toArray(); // ['firewalls' => [...], 'meta' => [...]]
```
