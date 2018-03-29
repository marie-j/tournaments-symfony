<?php

namespace App\Command;

use App\Entity\Tournament;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppCreateTournamentCommand extends Command
{
    private $doctrine;
    protected static $defaultName = 'app:create-tournament';
//
//    protected function configure()
//    {
//        $this
//            ->setDescription('Add a short description for your command')
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
//    }

    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct();

        $this->doctrine = $doctrine;
    }


    protected function configure()
    {
        //parent::configure();

        $this->setDescription('Create a tournament')
            ->addArgument('name', InputArgument::REQUIRED, 'The tournament\'s name')
            ->addArgument('date', InputArgument::REQUIRED, 'The tournament\'s date');

    }


//    protected function execute(InputInterface $input, OutputInterface $output)
//    {
//        $io = new SymfonyStyle($input, $output);
//        $argument = $input->getArgument('arg1');
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
//    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $name = $input->getArgument('name');
        $date = $input->getArgument('date');
        // parent::execute($input, $output);

        $tournament = new Tournament();
        $tournament->name = $name;
        $tournament->date = new \DateTimeImmutable($date);

        $manager = $this->doctrine->getManager();
        $manager->persist($tournament);
        $manager->flush();

        $output->writeln(sprintf('Tournament %s successfully added', $name));
    }


}
