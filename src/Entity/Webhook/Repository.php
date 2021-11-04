<?php

declare(strict_types=1);

namespace App\Entity\Webhook;

use ApiPlatform\Core\Annotation\ApiProperty;

final class Repository
{
    #[ApiProperty(example: 'git@github.com:Codertocat/Hello-World.git')]
    public string $sshUrl;

    #[ApiProperty(example: 'main')]
    public string $defaultBranch;
}
