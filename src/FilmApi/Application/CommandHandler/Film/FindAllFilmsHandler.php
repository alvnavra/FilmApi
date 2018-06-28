<?php
    namespace FilmApi\Application\CommandHandler\Film;
    use FilmApi\Domain\Repository\FilmRepository;

    class FindAllFilmsHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function handle()
        {
            return $this -> filmRepository -> findAllFilms();
        }

    }