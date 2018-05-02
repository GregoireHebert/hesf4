<?php

declare(strict_types=1);

namespace App\Command;

//use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

//class DeleteStaleProfiles extends ContainerAwareCommand
class DeleteStaleProfiles extends Command
{
    use LockableTrait;

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

            // ask for an argument. It can be optional or required or even is Array. You can combine the two .
            // ->addArgument('profiles',  InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Specific profiles to delete (ask for a user id')
            ->addArgument('period', InputArgument::OPTIONAL, 'The amount of time')

            // Adds an option
            ->addOption(
                'force-all',
                'a',
                InputOption::VALUE_NONE,
                'Should we also force to delete even the admin / super-admin users'
            );
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return 0;
        }

        // If you prefer to wait until the lock is released, use this:
        // $this->lock(null, true);

        $outputStyle = new OutputFormatterStyle('white', 'blue', array('bold'));
        $output->getFormatter()->setStyle('title', $outputStyle);

        $output->writeln([
            '<title>Deleting stale profiles</title>',
            '============',
            '',
        ]);
        $output->writeln('<comment>Delete every profiles without any connection within a given period.</comment>');
        if (null === $period = $input->getArgument('period')) {
            $helper = $this->getHelper('question');

            $periods = array('1 year', '6 months', '1 month', '2 weeks');
            $question = new Question('Please provide a staleness period.', 'year');
            $question->setAutocompleterValues($periods);

            $period = $helper->ask($input, $output, $question);
        }
        $output->writeln("<info>The period of staleness is: $period</info>");

        if ($input->getOption('force-all')) {
            $output->writeln('<info>Even the admin will be deleted !</info>');
        }

        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please select the profiles you want to clean (all by default)',
            array('standard', 'premium', 'gold'),
            '0,1,2'
        );
        $question->setErrorMessage('Profile %s is invalid.');
        $question->setMultiselect(true);

        $profile = $helper->ask($input, $output, $question);
        $output->writeln('You selected: "'.implode(', ', $profile). '" profiles to be cleaned.');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure?', false);

        if (!$helper->ask($input, $output, $question)) {
            return 0;
        }

        $output->writeln('<info>Ok done!</info>');

        // you can force manual release but symfony does it for you when the command end
        $this->release();
    }
}
