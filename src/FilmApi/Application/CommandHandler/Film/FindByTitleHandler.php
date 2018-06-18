<?php
    namespace FilmApi\Application\CommandHandler;
    use FilmApi\Domain\Repository\FilmRepository;

    class FindByTitleHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function execute(string $title)
        {
            $this -> filmRepository -> findFilmByTitleOrError($title);
        }

    }