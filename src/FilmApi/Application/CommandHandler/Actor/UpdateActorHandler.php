<?php
    namespace FilmApi\Application\CommandHandler\Actor;

    use FilmApi\Application\Command\Actor\CreateActorCommand;
    use FilmApi\Domain\Actor;
    use FilmApi\Domain\Repository\ActorRepository;

    class UpdateActorHandler
    {
        private $actorRepository;

        public function __construct(ActorRepository $actortRepository)
        {
            $this -> actorRepository = $actortRepository;
        }

        public function handle(CreateActorCommand $command):Actor
        {
            $actor = Actor::create($command -> name());
            $this -> actorRepository -> update($actor);
            return $actor;
        }
    }