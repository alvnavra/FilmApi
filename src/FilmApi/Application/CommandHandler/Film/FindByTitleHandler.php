<?php
    namespace FilmApi\Application\CommandHandler\Film;
    use FilmApi\Domain\Repository\FilmRepository;

    class FindByTitleHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function handle(string $title)
        {
            return $this -> filmRepository -> findFilmByTitleOrError($title);
        }

    }