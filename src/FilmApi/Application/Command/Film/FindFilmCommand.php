<?php
    namespace FilmApi\Application\Command\Film;

    class FindFilmCommand
    {
        private $allFilms;
        private $filmById;
        private $filmByTitle;
        private $filmsByActorId;

        public function __construct(bool $allFilms, bool $filmById, bool $filmByTitle, bool $filmByActor)
        {
            $this -> $allFilms          = $allFilms;
            $this -> $filmById          = $filmById;
            $this -> $filmByTitle       = $filmByTitle;
            $this -> $filmsByActor      = $filmsByActor;
        }

        public function allFilms():bool
        {
            return $this -> allFilms;
        }

        public function filmById():bool
        {
            return $this -> filmById;
        }

        public function filmByTitle():bool
        {
            return $this -> filmByTitle;
        }

        public function filmsByActor():bool
        {
            return $this -> filmsByActor;
        }



    }