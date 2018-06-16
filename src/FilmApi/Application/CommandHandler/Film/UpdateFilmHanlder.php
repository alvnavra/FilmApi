<?php
    namespace FilmApi\Application\CommandHandler\Film;

    use FilmApi\Application\Command\Film\CreateFilmCommand;
    use FilmApi\Domain\Film;
    use FilmApi\Domain\Repository\FilmRepository;

    class UpdateFilmHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function handle(CreateFilmCommand $command):Film
        {
            $film = Film::create($command -> title(),$command -> description());
            $this -> filmRepository -> update($film);
            return $film;
        }
    }