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
    - [Actions](#actions)
    - [Certificates](#certificates)
    - [Firewalls](#firewalls)

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

## Usage

### Actions

#### Get actions

Retrieves all available actions for a project, with a optional query parameters.

```php
$response = $client->actions()->getActions();
$response->actions; // array<int, Action>

foreach ($response->actions as $action) {
    echo $action->command;
}

$response->toArray(); // ['actions' => ['id => 1337', ...], 'meta' => [...]]
```

#### Get an action

Retrieves a single action for a project.

```php
$response = $client->actions()->getAction(1337);
$response->action; // Action::class
$response->toArray(); // ['action' => 'id => 1337', ...]
```

### Certificates

#### Create a certificate

Creates a certificate for a project. Both managed and uploaded certificate creations are supported.

```php
// Create a managed cert
$managed = $client->certificates()->createCertificate([
   'domain_names' => [
         'example.com', 
         'www.example.com' 
      ], 
   'name' => 'my website cert', 
   'type' => 'managed',
]);

echo $managed->action // Action::class
echo $managed->certificate // Certificate::class

// Upload a cert
$uploaded = $client->certificates()->createCertificate([
   'certificate' => '-----BEGIN CERTIFICATE-----...', 
   'name' => 'my website cert', 
   'private_key' => '-----BEGIN PRIVATE KEY-----...', 
   'type' => 'uploaded',
]);

echo $uploaded->action // Action::class
echo $uploaded->certificate // Certificate::class
```

### Firewalls

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
