<?php
    namespace FilmApiBundle\Command;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use FilmApi\Application\Command\Actor\ActorManager;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Input\InputArgument;

    

    class CreateConsoleActorCommand extends ContainerAwareCommand
    {

        protected function configure()
        {
            $this -> setName('app:create-actor')
                  -> setDescription('Create one actor')
                  -> setHelp('This command allows you to create an actor')
                  ->addArgument('actorname', InputArgument::REQUIRED, 'The name of the actor');

        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output -> writeln([
                'Create Actor',
                '============='
            ]);

            $name = $input->getArgument('actorname');
            $output->writeln('Actor Name: '.$name);

            $command = new ActorManager($name);
            $handler = $this->getContainer()->get('filmapi.command_handler.createActor');
            $actor = $handler -> handle($command);
            $this -> end();

        }
        private function end()
        {
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();
        }
    }