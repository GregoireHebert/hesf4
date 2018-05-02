<?php

declare(strict_types=1);

namespace App\Command;

//use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

//class DeleteStaleProfiles extends ContainerAwareCommand
class DeleteStaleProfiles extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:profile:delete-stale')

            // the short description shown while running "php bin/console list"
            ->setDescription('Delete every profiles without any connection within a period (default: "1 year").')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command should be used at least once a week. If a profile is deleted, remember the user has had warnings.')

            // ask for an argument. It can be optional or required.
            ->addArgument('period', InputArgument::OPTIONAL, 'The amount of time', '1 year')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Deleting stale profiles',
            '============',
            '',
        ]);
        $output->write('Delete every profiles without');
        $output->writeln(' any connection within a given period.');

        $output->writeln('The period of staleness is: '.$input->getArgument('period'));
    }
}
