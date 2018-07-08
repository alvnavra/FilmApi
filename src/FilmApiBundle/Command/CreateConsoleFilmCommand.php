<?php
    namespace FilmApiBundle\Command;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use FilmApi\Application\Command\Film\FilmManager;
    use FilmApi\Application\Command\Film\FilmTitleManager;
    use FilmApi\Application\Command\Actor\ActorManager;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Input\InputArgument;

    

    class CreateConsoleFilmCommand extends ContainerAwareCommand
    {

        protected function configure()
        {
            $this -> setName('app:create-film')
                  -> setDescription('Create one Film')
                  -> setHelp('This command allows you to create an film')
                  ->addArgument('filmTitle', InputArgument::REQUIRED, 'The title of the film')
                  ->addArgument('filmDescription', InputArgument::REQUIRED, 'The sypnopsys of the film')
                  ->addArgument('actorName', InputArgument::REQUIRED, 'The name of the main actor');

        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output -> writeln([
                'Create Film',
                '============='
            ]);

            $title = $input->getArgument('filmTitle');
            $output->writeln('Film Title: '.$title);

            $description = $input->getArgument('filmDescription');
            $output->writeln('Description: '.$description);

            $actorName = $input->getArgument('actorName');
            $output->writeln('Actor: '.$actorName);

            #Para insertar el film tenemos que traernos al actor cuyo nommbre hemos introducido.
            $command = new ActorManager($actorName);
            $handler = $this->getContainer()->get('filmapi.command_handler.findActorByName');
            $actor = $handler -> handle($command);

            $command = new FilmManager($title, $description, $actor);
            $handler = $this->getContainer()->get('filmapi.command_handler.createFilm');
            $actor = $handler -> handle($command);
            $this -> end();

        }
        private function end()
        {
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();
        }
    }