<?php
    namespace FilmApi\Application\CommandHandler\Film;

    use FilmApi\Application\Command\Film\FindFilmsCommand;
    use FilmApi\Domain\Repository\FilmRepository;

    Class FindFilmsHandler
    {
        private $filmRepository;

        public function __construct(ActorRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function execute(FindFilmsCommand $command, int $id,  string $itlte, int $actorId)
        {
            if ($command -> allFilms()) return $this -> fillmRepository -> findAllFilms();
            else
            {
                if ($command -> filmById()) return $this -> filmRepository -> findFilmByIdOrError($id);
                else
                {
                    if ($command -> FilmByTitle()) return $this -> filmRepository -> findFilmByTitleOrError($title);
                    else if ($command -> FilmByActorId()) return $this -> filmRepository -> findFilmByActorId($actorId);
                }
            }
        }
    }