---
outline: deep
---

# [Servers](https://docs.hetzner.cloud/#servers)

Servers are virtual machines that can be provisioned.

## Get servers

Retrieve all existing servers for a project. All query parameters are supported.

```php
$response = $client->servers()->getServers(sort: 'name:asc');
$response->servers; // array<int, Server>
$response->toArray(); // ['servers' => ['id' => 42, ...], 'meta' => [...]]
```

## Get server

Retrieve an existing server for a project.

```php
$response = $client->servers()->getServer(42069);
$response->server; // Server::class
$response->toArray(); // ['server' => ['id' => 42069, ...]]
```

# Create server

Create a server for a project. All payload parameters are supported.

```php
$response = $client->servers()->createServer([
    'name' => 'test-server',
    'server_type' => 'cpx11',
    'image' => 'ubuntu-24.04',
]);
$response->server // Server::class
$response->action // Action::class
$response->nextActions // Action[],
$response->rootPassword // string,
$response->toArray() // ['action' => [...], 'server' => [...], 'nextActions' => [...]]
```
