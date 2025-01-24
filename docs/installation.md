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

For a comprehensive set of examples, take a look at
the [examples](https://github.com/hetzner-cloud-php/client/tree/main/examples) directory.
