<?php
    namespace FilmApiBundle\Command;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use FilmApi\Application\Command\Film\FilmIdManager;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Input\InputArgument;

    

    class FindByIdConsoleFilmCommand extends ContainerAwareCommand
    {

        protected function configure()
        {
            $this -> setName('app:find-film-by-id')
                  -> setDescription('Find one existing film by his id')
                  -> setHelp('This command allows you to find a film by his id')
                  ->addArgument('filmId', InputArgument::REQUIRED, 'The id of the film');

        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output -> writeln([
                'Find Film',
                '============='
            ]);
            
            $id = $input->getArgument('filmId');
            $command = new FilmIdManager((int)$id);
            $handler = $this->getContainer()->get('filmapi.command_handler.findFilmById');
            $film = $handler -> handle($command);
            $output -> writeln('Id: '.$film->id());
            $output -> writeln('title: '.$film->title());
            $output -> writeln('description: '.$film->description());
            $output -> writeln('actor: '.$film->actor()->name());

        }
        private function end()
        {
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();
        }
    }