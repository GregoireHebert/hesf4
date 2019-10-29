<?php

declare(strict_types=1);

namespace App\Commands;

use App\Entity\PlacedOrder;
use App\Exceptions\ProductNotFoundException;
use App\MenuBuilder\MenuBuilder;
use App\Repository\PlacedOrderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class McDoCommand extends Command
{
    private $menuBuilder;
    private $placedOrderRepository;
    private $productRepository;

    public function __construct(MenuBuilder $menuBuilder, PlacedOrderRepository $placedOrderRepository, ProductRepository $productRepository)
    {
        parent::__construct();

        $this->menuBuilder = $menuBuilder;
        $this->placedOrderRepository = $placedOrderRepository;
        $this->productRepository = $productRepository;
    }

    protected function configure()
    {
        $this->setName('McDo:order');
        $this->setAliases(['m:o']);
        $this->addOption('menu', 'm', InputOption::VALUE_NONE, 'Display the menu.');
        $this->addArgument('name', InputOption::VALUE_REQUIRED, 'A name for the order.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Welcome to McDonald');

        $io->text(sprintf('How are you %s?', $input->getArgument('name')));
        $io->note('do not forget to practice a sport and eat 5 fruits and vegetables a day!');

        if ($input->getOption('menu')) {
            $this->showMenu($output);
            return;
        }

        if (null !== $order = $this->askForOrder($input, $output)) {
            $this->placedOrderRepository->persistAndSave($order);
            $io->success(sprintf('Order N° %s placed. Thank you!', $order->getNumber()));
        }
    }

    private function showMenu(OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders(['Item', 'Price']);

        $table->addRow([new TableCell('        Burgers', ['colspan' => 2])]);

        $table->addRow(['BigMac', '4.99']);
        $table->addRow(['CBO', '5.99']);
        $table->addRow(['Burger du moment', '6.99']);

        $table->addRow(new TableSeparator());

        $table->addRow([new TableCell('        Drinks', ['colspan' => 2])]);

        $table->addRow(['Coca', '1.99']);
        $table->addRow(['Orangina', '1.99']);
        $table->addRow(['Sprite', '1.99']);

        $table->addRow(new TableSeparator());

        $table->addRow([new TableCell('        Sides', ['colspan' => 2])]);

        $table->addRow(['Fries', '1.00']);

        $table->render();
    }

    private function askForOrder(InputInterface $input, OutputInterface $output): ?PlacedOrder
    {
        $burgers    = $this->productRepository->findBy(['category' => 'burger'], ['name' => 'ASC']);
        $drinks     = $this->productRepository->findBy(['category' => 'drink'], ['name' => 'ASC']);
        $sides      = $this->productRepository->findBy(['category' => 'side'], ['name' => 'ASC']);

        $confirmationQuestion   = new ConfirmationQuestion('<question>Do you want to eat to mcdo?</question>', true, '/^y|o|d/i');
        $anythingElseQuestion   = new ConfirmationQuestion('<question>Do you want anything else?</question>', true, '/^y|o|d/i');
        $moreQuestion           = new ConfirmationQuestion('<question>Do you want one more?</question>', false, '/^y|o|d/i');

        $nameQuestion       = new Question('<question>Can you give a name to the order?</question>', 'Anonymous');
        $howManyQuestion    = new Question('<question>How many do you want?</question>', 1);

        $burgerChoice   = new ChoiceQuestion('<question>What do you want to eat?</question>', $burgers, 0);
        $sideChoice     = new ChoiceQuestion('<question>What do you want aside?</question>', $sides, 0);
        $drinkChoice    = new ChoiceQuestion('<question>What do you want to drink?</question>', $drinks, 0);

        $questionHelper = new QuestionHelper();

        $io = new SymfonyStyle($input, $output);
        $io->title('New Order');

        // Do you want to eat?
        if (!$questionHelper->ask($input, $output, $confirmationQuestion)) {
            return null;
        }

        // give a name
        $this->menuBuilder->setName($questionHelper->ask($input, $output, $nameQuestion));

        // burgers
        do {
            $burger = $questionHelper->ask($input, $output, $burgerChoice);
            $quantity = (int) $questionHelper->ask($input, $output, $howManyQuestion);

            $this->menuBuilder->addSelection($burger, $quantity);
        } while ($questionHelper->ask($input, $output, $moreQuestion));

        // sides
        do {
            $side = $questionHelper->ask($input, $output, $sideChoice);
            $quantity = (int) $questionHelper->ask($input, $output, $howManyQuestion);

            $this->menuBuilder->addSelection($side, $quantity);
        } while ($questionHelper->ask($input, $output, $moreQuestion));

        // drinks
        do {
            $drink = $questionHelper->ask($input, $output, $drinkChoice);
            $quantity = (int) $questionHelper->ask($input, $output, $howManyQuestion);

            $this->menuBuilder->addSelection($drink, $quantity);
        } while ($questionHelper->ask($input, $output, $moreQuestion));

        // forgot something?
        do {
            if (false === $questionHelper->ask($input, $output, $anythingElseQuestion)) {
                break;
            }

            $whatDoYouNeedQuestion = new Question('What do you need?', false);

            if (false === $else = $questionHelper->ask($input, $output, $whatDoYouNeedQuestion)) {
                break;
            }

            $quantity = (int) $questionHelper->ask($input, $output, $howManyQuestion);

            try {
                $this->menuBuilder->addSelection($else, $quantity);
            } catch (ProductNotFoundException $e) {
                $output->writeln("We do not have anymore $else");
            }
        } while ($questionHelper->ask($input, $output, $anythingElseQuestion));

        return $this->menuBuilder->createOrder();
    }
}
