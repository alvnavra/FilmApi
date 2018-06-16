<?php
    namespace FilmApi\Application\CommandHandler\Film;

    use FilmApi\Application\Command\Film\CreateFilmCommand;
    use FilmApi\Domain\Film;
    use FilmApi\Domain\Repository\FilmRepository;

    class DeletFilmHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function handle(CreateFilmCommand $command):Film
        {
            $film = Film::create($command -> title(),$command -> description());
            $this -> filmRepository -> delete($film);
            return $film;
        }
    }