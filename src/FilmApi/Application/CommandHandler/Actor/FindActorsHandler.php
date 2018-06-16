<?php
    namespace FilmApi\Application\CommandHandler\Actor;

    use FilmApi\Application\Command\Actor\FindActorsCommand;
    use FilmApi\Domain\Repository\ActorRepository;

    Class FindActorsHandler
    {
        private $actorRepository;

        public function __construct(ActorRepository $actorRepository)
        {
            $this -> actorRepository = $actorRepository;
        }

        public function execute(FindActorsCommand $command, int $id, string $name)
        {
            if ($command -> allActors()) return $this -> actorRepository -> findAllActors();
            else
            {
                if ($command -> actorById()) return $this -> actorRepository -> findActorByIdOrError($id);
                else
                {
                    if ($command -> actorByName()) return $this -> actorRepository -> findActorByNameOrError($name);
                }
            }
        }
    }