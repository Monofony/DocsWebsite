<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

#[AsCommand(
    name: 'app:copy-images',
    description: 'Copy images from docs to public directory.',
)]
class CopyImagesCommand extends Command
{
    public function __construct(
        private string $docsDir,
        private string $publicDir,
        private Filesystem $filesystem
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('version', InputArgument::OPTIONAL, 'Version name or path')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $version = $input->getArgument('version');

        if (null !== $version) {
            $version = basename($version);
        }

        $finder = new Finder();
        foreach ($finder->path('_images')->in($this->docsDir)->directories() as $directory) {
            $versionDir = $directory->getRelativePath();
            $imagesDir = $directory->getPathname();

            if (null !== $version && $versionDir !== $version) {
                continue;
            }

            $this->copyImagesToPublic($versionDir, $imagesDir, $io);
        }

        $io->success('Images have been successfully copied.');

        return Command::SUCCESS;
    }

    private function copyImagesToPublic(string $versionDir, string $imagesDir, SymfonyStyle $io): void
    {
        $targetDir = $this->publicDir
            .DIRECTORY_SEPARATOR.$versionDir
            .DIRECTORY_SEPARATOR.'_images';

        $this->copyImages($imagesDir, $targetDir, $io);
    }

    private function copyImages(string $imagesDir, $targetDir, SymfonyStyle $io): void
    {
        $finder = new Finder();
        foreach ($finder->in($imagesDir)->files() as $file) {
            $originFile = $file->getPathname();
            $targetFile = $targetDir.DIRECTORY_SEPARATOR.$file->getRelativePathname();

            $io->info(sprintf('Copy image "%s" into "%s"', $file->getRelativePathname(), $targetFile));

            $this->filesystem->copy($originFile, $targetFile, true);
        }
    }
}
