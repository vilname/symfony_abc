<?php

declare(strict_types=1);

namespace App\ConsoleCommand;

use App\Command\Product\ProductHandle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:calculate-score',
    description: 'Расчет скоринга пользователей',
    aliases: ['app:calculate-score'],
    hidden: false
)]
class CalculateScoreCommand extends Command
{
    public function __construct(
        private readonly ProductHandle $handle
    ) {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $userId = (int)$input->getArgument('userId');
        if (!empty($userId)) {
            $response = [];
            $responses = [$response];
        } else {
            $responses = $this->handle->handle();
        }

        $this->responseOutput($output, $responses);

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addArgument('userId', InputArgument::OPTIONAL, 'Id пользователя');
    }

    /**
     * @param OutputInterface $output
     * @param array $responses
     */
    private function responseOutput(OutputInterface $output, array $responses)
    {
        if (empty($responses)) {
            $output->writeln('Нет пользователей без расчитанного скоринга!');
        }

        foreach ($responses as $response) {
            $user = sprintf(
                'Id: %d, Пользователь: %s',
                $response->user->getId(), $response->user->getLastName() . ' ' . $response->user->getFirstName()
            );

            $output->writeln($user);

            $scoreTotal = 0;
            foreach ($response->scoreRules as $scoreRule) {
                $scoreTotal += $scoreRule->getScore();
                $output->writeln($scoreRule->getName() . ': ' . $scoreRule->getScore());
            }

            $output->writeln('Скоринг всего: ' . $scoreTotal);
            $output->writeln('====================');
        }
    }
}