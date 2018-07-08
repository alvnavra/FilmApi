<?php
    namespace FilmApiBundle\Command;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use FilmApi\Application\Command\Actor\ActorManager;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Input\InputArgument;

    

    class FindByNameConsoleActorCommand extends ContainerAwareCommand
    {

        protected function configure()
        {
            $this -> setName('app:find-actor-by-name')
                  -> setDescription('Find one existing by his name')
                  -> setHelp('This command allows you to find an actor by his name')
                  ->addArgument('actorname', InputArgument::REQUIRED, 'The name of the actor');

        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output -> writeln([
                'Find Actor',
                '============='
            ]);

            $name = $input->getArgument('actorname');
            $command = new ActorManager($name);
            $handler = $this->getContainer()->get('filmapi.command_handler.findActorByName');
            $actor = $handler -> handle($command);
            $output -> writeln('Id: '.$actor->id());
            $output -> writeln('Name: '.$actor->name());

        }
        private function end()
        {
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();
        }
    }