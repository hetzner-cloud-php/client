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
    - [Certificates actions](#certificate-actions)
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
$response->toArray(); // ['action' => 'id' => 1337, ...]
```

### `Certificates`

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

echo $managed->action; // Action::class
echo $managed->certificate; // Certificate::class

// Upload a cert
$uploaded = $client->certificates()->createCertificate([
   'certificate' => '-----BEGIN CERTIFICATE-----...', 
   'name' => 'my website cert', 
   'private_key' => '-----BEGIN PRIVATE KEY-----...', 
   'type' => 'uploaded',
]);

echo $uploaded->action; // Action::class
echo $uploaded->certificate; // Certificate::class
```

### Get a certificate

Get a certificate for a project by an ID.

```php
$response = $client->certificates()->getCertificate(42);

echo $response->certificate // Certificate::class
echo $response->toArray() // ['certificate' => ['id' => 42, ...]
```

### Get all certificates

Get all certificates for a projects with optional query parameters.

```php
$response = $client->certificates()->getCertificates(name: 'name:asc');

echo $response->certificates // array<int, Certificate>
echo $response->meta // Meta::class
echo $response->toArray() // ['certificates' => ['id' => 42, ...], 'meta' => [...]]
```

### Update a certificate

```php
$response = $client->certificates()->updateCertificate(42, [
        'name' => 'test-certificate-updated',
        'labels' => [
            'foo' => 'bar',
        ],
    ]);

echo $response->certificate // Certificate::class
echo $response->toArray() // ['certificate' => ['id' => 42, 'name' => 'test-certificate-updated', ...]
```

### Delete a certificate

Delete a certificate, with the response being an instance of a PSR-7 response.

```php
$response = $client->certificates()->deleteCertificate(42);
assert($response->getStatusCode() === 204);
```

### `Certificate Actions`

#### Get all actions

Get a list of all actions associated to certificates for a project.

```php
$response = $client
    ->certificates()
    ->actions()
    ->getActions(status: 'pending');

echo $response->actions // array<int, Action>
echo $response->meta // Meta::class
echo $response->toArray() // ['actions' => ['id' => 42, ...], 'meta' => [...]]
```

#### Get an action

Get an action associated to certificates for a project.

```php
$response = $client
    ->certificates()
    ->actions()
    ->getAction(42);

echo $response->action // Action::class
echo $response->toArray() // ['action' => ['id' => 42, ...], 'error' => null]
```

#### Get all actions for a certificate

Get a list of all actions associated to a single certificate. Allows for optional query parameters.

```php
$response = $client
    ->certificates()
    ->actions()
    ->getCertificateActions(42, perPage: 5, sort: 'pending');

echo $response->actions // array<int, Action>
echo $response->meta // Meta::class
echo $response->toArray() // ['actions' => ['id' => 42, ...], 'meta' => [...]]
```

#### Get an action for a certificate

Get an action associated to a certificate. Requires both the certificate and action ID.

```php
$response = $client
    ->certificates()
    ->actions()
    ->getCertificateAction(420, 69);

echo $response->action // Action::class
echo $response->toArray() // ['action' => ['id' => 420, ...], 'error' => null]
```

#### Retry issuance or renewal

Retry a failed Certificate issuance or renewal. Only applicable if the type of the Certificate is `managed` and the
issuance or renewal status is `failed`.

```php
$response = $client
    ->certificates()
    ->actions()
    ->retryIssuanceOrRenewal(42); // Takes the certificate ID

echo $response->action // Action::class
echo $response->toArray() // ['action' => ['id' => 69, ...], 'error' => null]
```

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

### `Servers`

#### Get all servers

Gets a list of all existing servers for a project.

```php
$response = $client->servers()->getServers(sort: 'name:asc');
$response->servers; // array<int, Server>
$response->toArray(); // ['servers' => ['id' => 42, ...], 'meta' => [...]]
```

#### Get a server

TODO

#### Create a server

TODO

#### Delete a server

TODO

#### Update a server

TODO

### Get metrics for a server

TODO
