<?php

declare(strict_types=1);

namespace App\Message;

final class UpdateDocs
{
    public string $branch;

    public function __construct(string $branch)
    {
        $this->branch = $branch;
    }
}
