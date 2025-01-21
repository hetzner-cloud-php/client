<?php

declare(strict_types=1);

use HetznerCloud\HetznerCloud;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

/** @var string $apiKey */
$apiKey = $_ENV['HETZNER_CLOUD_API_KEY'];
$client = HetznerCloud::client($apiKey);

// Get a list of certificates
$certificates = $client->certificates()->getCertificates();
var_dump($certificates);

if ($certificates->certificates !== []) {
    // Get a single certificate
    $certificate = $client->certificates()->getCertificate($certificates->certificates[0]->id);
    var_dump($certificate);

    // Update a certificate
    $updatedCertificate = $client->certificates()->updateCertificate($certificate->certificate->id ?? 1, [
        'name' => 'test-certificate-updated',
        'labels' => [
            'foo' => 'bar',
        ],
    ]);
}

// Create a certificate
$createdCertificate = $client->certificates()->createCertificate([
    'name' => 'test-certificate-created',
    'labels' => [
        'foo' => 'bar',
    ],
]);
var_dump($createdCertificate);

// Delete a certificate
$response = $client->certificates()->deleteCertificate($createdCertificate->certificate->id);
assert($response->getStatusCode() === 204);
var_dump($response);
