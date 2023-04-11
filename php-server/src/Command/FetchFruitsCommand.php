<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Service\FetchFruits;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:fetch-fruits')]
class FetchFruitsCommand extends Command
{

    public function __construct(private FetchFruits $fetchFruits)
    {
        parent::__construct();
    }


    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to fetch data from ' .
                'https://fruityvice.com and store into database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->fetchFruits->fetch();
        $output->write("Fetched = " . $result['fetchCount'] . PHP_EOL);
        $output->write("Inserted/Updated = " . $result['upsertCount'] . PHP_EOL);
        return Command::SUCCESS;
    }
}
