<?php

namespace App\Command;

use App\Service\Greeting;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command
{
    private $greeting;

    public function __construct(Greeting $greeting, $name = null)
    {
        $this->greeting = $greeting;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('app:say-hello')
            ->setDescription('Says hello to the user')
            ->addArgument('name', InputArgument::REQUIRED, 'name to greet');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $output->writeln([
            'Hello from the app',
            '===================',
            ''
        ]);
        $output->writeln($this->greeting->greet($name));
    }
}
