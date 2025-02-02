<?php

declare(strict_types=1);

namespace Tests\Exceptions;

use Exception;
use HetznerCloud\Exceptions\HetznerCloudException;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Testing\Fixtures\ErrorFixture;
use RuntimeException;

covers(HetznerCloudException::class);

describe(HetznerCloudException::class, function (): void {
    it('constructs with error and status code', function (): void {
        // Arrange
        $error = Error::from([
            'code' => 'invalid_input',
            'message' => 'Invalid server type provided.',
        ]);

        // Act
        $exception = new HetznerCloudException($error, 400);

        // Assert
        expect($exception)
            ->error->toBe($error)
            ->statusCode->toBe(400)
            ->getMessage()->toBe('Invalid server type provided.')  // Verify parent constructor was called
            ->and($exception)->toBeInstanceOf(Exception::class);  // Verify inheritance
    });

    it('creates from error response array', function (): void {
        // Arrange
        $errorData = [
            'error' => ErrorFixture::data(),
        ];

        // Act
        $exception = HetznerCloudException::from($errorData, 429);

        // Assert
        expect($exception)
            ->toBeInstanceOf(HetznerCloudException::class)
            ->error->toBeInstanceOf(Error::class)
            ->statusCode->toBe(429)
            ->and($exception->error->code)->toBe('invalid_input')
            ->and($exception->error->message)->toBe("invalid input in fields 'server_type', 'source_server', 'image'")
            ->and($exception->getMessage())->toBe("invalid input in fields 'server_type', 'source_server', 'image'");
    });

    it('throws runtime exception when error key is missing', function (): void {
        // Arrange
        $invalidErrorData = [
            'message' => 'Some error occurred',  // Missing 'error' key
        ];

        // Act & Assert
        expect(fn (): HetznerCloudException => HetznerCloudException::from($invalidErrorData, 400))
            ->toThrow(RuntimeException::class, 'Response error is not set.');
    });

    it('throws runtime exception when error key is null', function (): void {
        // Arrange
        $invalidErrorData = [
            'error' => null,
        ];

        // Act & Assert
        expect(fn (): HetznerCloudException => HetznerCloudException::from($invalidErrorData, 400))
            ->toThrow(RuntimeException::class, 'Response error is not set.');
    });

    it('preserves complete error information', function (): void {
        // Arrange
        $errorData = [
            'error' => ErrorFixture::data(),
        ];

        // Act
        $exception = HetznerCloudException::from($errorData, 404);

        // Assert
        expect($exception->error)
            ->toBeInstanceOf(Error::class)
            ->code->toBe('invalid_input')
            ->message->toBe("invalid input in fields 'server_type', 'source_server', 'image'")
            ->and($exception)
            ->statusCode->toBe(404)
            ->getMessage()->toBe("invalid input in fields 'server_type', 'source_server', 'image'");
    });
});
