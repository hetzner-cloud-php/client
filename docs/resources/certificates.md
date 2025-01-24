---
outline: deep
---

# [Certificates](https://docs.hetzner.cloud/#certificates)

TLS/SSL Certificates prove the identity of a Server and are used to encrypt client traffic.

## Create a certificate

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

## Get a certificate

Get a certificate for a project by an ID.

```php
$response = $client->certificates()->getCertificate(42);

echo $response->certificate // Certificate::class
echo $response->toArray() // ['certificate' => ['id' => 42, ...]
```

## Get all certificates

Get all certificates for a projects with optional query parameters.

```php
$response = $client->certificates()->getCertificates(name: 'name:asc');

echo $response->certificates // array<int, Certificate>
echo $response->meta // Meta::class
echo $response->toArray() // ['certificates' => ['id' => 42, ...], 'meta' => [...]]
```

## Update a certificate

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

## Delete a certificate

Delete a certificate, with the response being an instance of a PSR-7 response.

```php
$response = $client->certificates()->deleteCertificate(42);
assert($response->getStatusCode() === 204);
```
