<?php
    namespace FilmApi\Application\CommandHandler\Film;
    use FilmApi\Application\CommandHandler\Actor\FindActorByName;
    use FilmApi\Application\Command\Film\FilmManager;
    use FilmApi\Domain\Film;
    use FilmApi\Domain\Actor;
    use FilmApi\Domain\Repository\FilmRepository;

    class CreateFilmHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function handle(FilmManager $command):Film
        {
            $film = Film::create($command -> title(),$command -> description(), $command -> actor());
            $this -> filmRepository -> save($film);
            return $film;
        }
    }