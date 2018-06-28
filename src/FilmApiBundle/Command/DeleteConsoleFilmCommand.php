<?php
    namespace FilmApiBundle\Command;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use FilmApiBundle\Decorators\FilmDecorator;
    use FilmApi\Application\Command\Film\FilmManager;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Input\InputArgument;

    

    class DeleteConsoleFilmCommand extends ContainerAwareCommand
    {

        protected function configure()
        {
            $this -> setName('app:delete-film')
                  -> setDescription('Delete one existing film')
                  -> setHelp('This command allows you to delete a film')
                  ->addArgument('filmTitle', InputArgument::REQUIRED, 'The title of the film');

        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output -> writeln([
                'Delete Film',
                '============='
            ]);

            $title = $input->getArgument('filmTitle');
            $output->writeln('Film Title: '.$title);
            $handler = $this->getContainer()->get('filmapi.command_handler.findFilmByTitle');
            $film = $handler -> handle($title);

            $handler = $this->getContainer()->get('filmapi.command_handler.deleteFilm');
            $actor = $handler -> handle($title, $film->description(), $film->actor());
            $this -> end();

        }
        private function end()
        {
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();
        }
    }