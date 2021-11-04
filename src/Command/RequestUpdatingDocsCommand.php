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

namespace App\Command;

use App\Message\UpdateDocs;
use App\Message\UpdateProjectMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:request-updating-docs',
    description: 'Request updating docs with the latest version..',
)]
class RequestUpdatingDocsCommand extends Command
{
    public function __construct(private MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('branch', InputArgument::OPTIONAL, 'Branch name', 'main')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $branch = $input->getArgument('branch');

        $this->messageBus->dispatch(new UpdateDocs($branch));

        $io->success('Your request has been successfully created.');

        return Command::SUCCESS;
    }
}
