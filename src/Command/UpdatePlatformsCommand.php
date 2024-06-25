<?php

namespace App\Command;

use Exception;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'update-platforms',
    description: 'Update Platforms data in Redis',
)]
class UpdatePlatformsCommand extends Command
{
    private $redis;
    private $platforms;

    public function __construct(ClientInterface $client)
    {
        parent::__construct();
        $this->redis = $client;
        $this->platforms = array();
    }

    private function getCsvData(string $filepath): bool
    {
        $row = 1;
        if (($handle = fopen($filepath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row === 1) {
                    $row++;
                    continue;
                }
                $num = count($data);
                $row++;
                $id = $data[0];
                $name = $data[1];
                $this->platforms[$id] = $name;
            }
            return true;
        }
        return false;
    }

    private function setPlatforms(): bool
    {
        $serialized_platforms = serialize($this->platforms);
        try {
            $this->redis->set('platforms', $serialized_platforms);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function configure(): void
    {
        $help = 'This command allows you to pass in a CSV file to update ';
        $help .= 'the `platforms` key in Redis.';

        $this
            ->addArgument(
                'file',
                InputArgument::OPTIONAL,
                'Full path to the CSV file'
            )
            ->setDescription('Updates the Platforms key in Redis')
            ->setHelp($help);
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('file');

        if ($arg1) {
            $result = $this->getCsvData($arg1);
            if (!$result) {
                return Command::FAILURE;
            }
        }

        $result = $this->setPlatforms();
        if (!$result) {
            return Command::FAILURE;
        }

        // if ($input->getOption('option1')) {
        // ...
        // }

        // $msg = 'You have a new command! Now make it your own! ';
        // $msg .= 'Pass --help to see your options.';
        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        // $io->success($msg);
        // print_r($this->platforms);

        return Command::SUCCESS;
    }
}
