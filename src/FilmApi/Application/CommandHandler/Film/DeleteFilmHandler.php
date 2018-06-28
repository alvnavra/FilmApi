<?php
    namespace FilmApi\Application\CommandHandler\Film;

    use FilmApi\Application\Command\Film\CreateFilmCommand;
    use FilmApi\Domain\Film;
    use FilmApi\Domain\Repository\FilmRepository;

    class DeleteFilmHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function handle(string $title):void
        {
            $film = $this -> filmRepository -> delete($title);
        }
    }