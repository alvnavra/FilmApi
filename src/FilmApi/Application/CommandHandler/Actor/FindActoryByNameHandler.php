<?php
    namespace FilmApi\Application\CommandHandler\Actor;
    use FilmApi\Domain\Repository\ActorRepository;

    Class FindActoryByNameHandler
    {
        private $actorRepository;

        public function __construct(ActorRepository $actorRepository)
        {
            $this -> actorRepository = $actorRepository;
        }

        public function execute(string $name)
        {
            return $this -> actorRepository -> findActorByNameOrError($name);
        }
    }