<div align="center" style="padding-top: 2rem;">
    <img src="assets/hetzner_logo.svg" height="100" width="300" alt="logo"/>
    <div style="display: inline-block; padding-top: 2rem">
        <img src="https://img.shields.io/packagist/v/hetzner-cloud-php/client.svg?style=flat-square" alt="packgist downloads" />
        <img src="https://img.shields.io/github/actions/workflow/status/hetzner-cloud-php/client/run-tests.yml?branch=main&label=tests&style=flat-square" alt="tests ci" />
        <img src="https://img.shields.io/github/actions/workflow/status/hetzner-cloud-php/client/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square" alt="packgist downloads" />
        <img src="https://img.shields.io/packagist/dt/hetzner-cloud-php/client.svg?style=flat-square" alt="packgist downloads" />
    </div>
</div>

## Hetzner Cloud PHP

A PHP client for the Hetzner Cloud API. Description coming soon™️...

## Table of Contents

- [Getting started](#get-started)

## Usage

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
