<?php
    namespace FilmApi\Application\CommandHandler\Actor;

    use FilmApi\Application\Command\Actor\CreateActorCommand;
    use FilmApi\Domain\Actor;
    use FilmApi\Domain\Repository\ActorRepository;

    class CreateActorHandler
    {
        private $actorRepository;

        public function __construct(ActorRepository $actorRepository)
        {
            $this -> actorRepository = $actorRepository;
        }

        public function handle(CreateActorCommand $command):Actor
        {
            $actor = Actor::create($command -> name());
            $this -> actorRepository -> save($actor);
            return $actor;
        }
    }