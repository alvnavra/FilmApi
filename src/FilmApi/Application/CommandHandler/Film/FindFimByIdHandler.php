<?php
    namespace FilmApi\Application\CommandHandler;
    use FilmApi\Domain\Repository\FilmRepository;

    class FindFimByIdHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function execute(int $id)
        {
            return $this -> filmRepository -> findFilmByIdOrError($id);
        }

    }