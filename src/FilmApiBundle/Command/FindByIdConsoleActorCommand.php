<?php
    namespace FilmApiBundle\Command;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use FilmApiBundle\Decorators\ActorDecorator;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Input\InputArgument;

    

    class FindByIdConsoleActorCommand extends ContainerAwareCommand
    {

        protected function configure()
        {
            $this -> setName('app:find-actor-by-id')
                  -> setDescription('Find one existing by his id')
                  -> setHelp('This command allows you to find an actor by his id')
                  ->addArgument('actorid', InputArgument::REQUIRED, 'The id of the actor');

        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output -> writeln([
                'Find Actor',
                '============='
            ]);

            $name = $input->getArgument('actorid');
            $handler = $this->getContainer()->get('filmapi.command_handler.findActorById');
            $actor = $handler -> handle($name);
            $output -> writeln('Id: '.$actor->id());
            $output -> writeln('Name: '.$actor->name());

        }
        private function end()
        {
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();
        }
    }