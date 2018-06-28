<?php
    namespace FilmApiBundle\Command;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use FilmApiBundle\Decorators\FilmDecorator;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Input\InputArgument;

    

    class FindAllConsoleFilmCommand extends ContainerAwareCommand
    {

        protected function configure()
        {
            $this -> setName('app:find-all-films')
                  -> setDescription('Find all the films on the DB')
                  -> setHelp('This command allows you to find all the films on the DB');
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output -> writeln([
                'Find Films',
                '============================================================'
            ]);

            $handler = $this->getContainer()->get('filmapi.command_handler.findAllFilms');
            $films = $handler -> handle();
            foreach ($films as $film)
            {   
                $output -> writeln(['Film Id: '.$film['id'],
                                     '  Title           : '.$film['title'],
                                     '  Description     : '.$film['description'],
                                     '  Actor           : '.$film['actor']->name(),
                                     '-------------------------']);
    
            }


        }
        private function end()
        {
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();
        }
    }