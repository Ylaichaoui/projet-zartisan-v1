<?php

namespace App\Command;

use App\Manager\ManualFixtureManagerV2;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:db';
    private $manualFixtureManager;

    public function __construct(ManualFixtureManagerV2 $manualFixtureManager)
    {
        $this->manualFixtureManager = $manualFixtureManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->manualFixtureManager->load();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        return 0;
    }
}