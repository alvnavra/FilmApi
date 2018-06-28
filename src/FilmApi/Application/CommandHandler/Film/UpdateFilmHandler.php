<?php
    namespace FilmApi\Application\CommandHandler\Film;

    use FilmApi\Application\Command\Film\FilmManager;
    use FilmApi\Domain\Film;
    use FilmApi\Domain\Repository\FilmRepository;

    class UpdateFilmHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function handle(FilmManager $command):Film
        {
            $film = Film::create($command -> title(),$command -> description(),$command -> actor());
            $this -> filmRepository -> update($film);
            return $film;
        }
    }