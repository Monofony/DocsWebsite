<?php

/*
 * This file is part of the Propale Numérique project.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Client;

use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;
use Webmozart\Assert\Assert;

final class GitClient
{
    private string $gitPath;

    public function __construct()
    {
        $executableFinder = new ExecutableFinder();
        $gitPath = $executableFinder->find('git');
        Assert::notNull($gitPath, 'Git executable was not found.');

        $this->gitPath = $gitPath;
    }

    public function pull(): Process
    {
        return new Process([$this->gitPath, 'pull']);
    }
}
