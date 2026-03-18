<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeeklyResolutionService;

#[AsCommand(
    name: 'app:weekly-twin-outcome',
    description: 'Résout la semaine écoulée et prépare la suivante + Attribue automatiquement les achievements aux utilisateurs',
)]
class WeeklyTwinOutcomeCommand extends Command
{
    public function __construct(
        private WeeklyResolutionService $weeklyResolutionService,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->weeklyResolutionService->resolveCurrentWeek();

        $io->success('La semaine a bien été résolue.');

        return Command::SUCCESS;
    }
}