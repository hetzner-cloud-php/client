---
outline: deep
---

# [Certificate Actions](https://docs.hetzner.cloud/#certificate-actions)

Actions available for specifically for certificate requests.

## Get all actions

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

## Get an action

Get an action associated to certificates for a project.

```php
$response = $client
    ->certificates()
    ->actions()
    ->getAction(42);

echo $response->action // Action::class
echo $response->toArray() // ['action' => ['id' => 42, ...], 'error' => null]
```

## Get all actions for a certificate

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

## Get an action for a certificate

Get an action associated to a certificate. Requires both the certificate and action ID.

```php
$response = $client
    ->certificates()
    ->actions()
    ->getCertificateAction(420, 69);

echo $response->action // Action::class
echo $response->toArray() // ['action' => ['id' => 420, ...], 'error' => null]
```

## Retry issuance or renewal

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
