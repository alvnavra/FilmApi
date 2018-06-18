<?php
    namespace FilmApi\Application\CommandHandler;
    use FilmApi\Domain\Repository\FilmRepository;
    use FilmApi\Domain\Actor\Actor;

    class FindFilmsByActorHandler
    {
        private $filmRepository;

        public function __construct(FilmRepository $filmRepository)
        {
            $this -> filmRepository = $filmRepository;
        }

        public function execute(Actor $actor)
        {
            $this -> filmRepository -> findFilmsByActor($actor);
        }

    }