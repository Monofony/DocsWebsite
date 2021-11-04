<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Webhook\Webhook;
use App\Message\UpdateDocs;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class WebhookHandler implements MessageHandlerInterface
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private string $docsSshUrl
    ) {
    }

    public function __invoke(Webhook $webhook): void
    {
        $sshUrl = $webhook->repository->sshUrl;
        $branch = 'main';

        if ($this->docsSshUrl !== $sshUrl) {
            return;
        }

        $this->messageBus->dispatch(new UpdateDocs($branch));
    }
}
