<?php

declare(strict_types=1);

namespace App\Entity\Webhook;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    collectionOperations: [
        'post' => [
            'status' => 202,
        ],
    ],
    itemOperations: [],
    messenger: true,
    output: false,
)]
final class Webhook
{
    #[ApiProperty(example: 'refs/tags/simple-tag')]
    public string $ref;

    public bool $created;

    public bool $deleted;

    public bool $forced;

    public Repository $repository;
}
