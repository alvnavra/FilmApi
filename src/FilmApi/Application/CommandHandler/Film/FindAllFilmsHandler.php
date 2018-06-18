<?php
    namespace FilmApi\Application\CommandHandler;
    use FilmApi\Domain\Repository\FilmRepository;

    class FindAllFilmsHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function execute()
        {
            return $this -> filmRepository -> findAllFilms();
        }

    }