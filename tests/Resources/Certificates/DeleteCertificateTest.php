<?php

declare(strict_types=1);

use HetznerCloud\Resources\CertificatesResource;
use Tests\Mocks\ClientMock;

covers(CertificatesResource::class);

describe('certificate', function (): void {
    it('can delete a certificate', function (): void {
        // Arrange
        $response = new GuzzleHttp\Psr7\Response(204);
        $client = ClientMock::delete(
            'certificates/42069',
            $response,
            methodName: 'sendStandardClientRequest',
        );

        // Act
        $result = $client->certificates()->deleteCertificate(42069);

        // Assert
        expect($result)
            ->toBeInstanceOf(Psr\Http\Message\ResponseInterface::class)
            ->getStatusCode()->toBe(204);
    });
});
