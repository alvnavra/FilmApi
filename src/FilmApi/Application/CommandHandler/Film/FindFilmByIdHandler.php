<?php
    namespace FilmApi\Application\CommandHandler\Film;
    use FilmApi\Domain\Repository\FilmRepository;
      class FindFilmByIdHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function handle(int $id)
        {
            return $this -> filmRepository -> findFilmByIdOrError($id);
        }

    }