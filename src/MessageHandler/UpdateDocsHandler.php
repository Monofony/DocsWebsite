<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Client\GitClient;
use App\Message\UpdateDocs;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Webmozart\Assert\Assert;

final class UpdateDocsHandler implements MessageHandlerInterface
{
    public function __construct(private string $docsDir, private GitClient $gitClient)
    {
    }

    public function __invoke(UpdateDocs $message)
    {
        Assert::directory($this->docsDir);

        $branchDir = $this->getBranchDir($message);

        $process = $this->gitClient->pull();
        $process->setWorkingDirectory($branchDir);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new UnrecoverableMessageHandlingException($process->getOutput());
        }
    }

    private function getBranchDir(UpdateDocs $message): string
    {
        $branchDir = 'main' !== $message->branch ? $message->branch : 'current';

        return $this->docsDir.DIRECTORY_SEPARATOR.$branchDir;
    }
}
