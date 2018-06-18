<?php
    namespace FilmApi\Application\CommandHandler\Actor;
    use FilmApi\Domain\Repository\ActorRepository;

    Class FindActorByIdHandler
    {
        private $actorRepository;

        public function __construct(ActorRepository $actorRepository)
        {
            $this -> actorRepository = $actorRepository;
        }

        public function execute(int $id)
        {
            return $this -> actorRepository -> findActorByIdOrError($id);
        }
    }