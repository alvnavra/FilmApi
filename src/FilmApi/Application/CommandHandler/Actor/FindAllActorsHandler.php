<?php
    namespace FilmApi\Application\CommandHandler\Actor;
    use FilmApi\Domain\Repository\ActorRepository;

    Class FindAllActorsHandler
    {
        private $actorRepository;

        public function __construct(ActorRepository $actorRepository)
        {
            $this -> actorRepository = $actorRepository;
        }

        public function execute()
        {
            return $this -> actorRepository -> findAllActors();            
        }
    }