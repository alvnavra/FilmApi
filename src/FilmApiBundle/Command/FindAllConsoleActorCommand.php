<?php
    namespace FilmApiBundle\Command;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use FilmApiBundle\Decorators\ActorDecorator;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Input\InputArgument;

    

    class FindAllConsoleActorCommand extends ContainerAwareCommand
    {

        protected function configure()
        {
            $this -> setName('app:find-all-actors')
                  -> setDescription('Find all actors on the DB.')
                  -> setHelp('This command allows you to find all the actors');
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output -> writeln([
                'Find Actors',
                '========================================================='
            ]);

            $handler = $this->getContainer()->get('filmapi.command_handler.findAllActors');
            $actors = $handler -> handle();
            foreach ($actors as $actor)
            {                
                $output -> writeln($actor['id'].'   '.$actor['name']);
    
            }

        }
        private function end()
        {
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();
        }
    }