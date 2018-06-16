<?php
    namespace FilmApi\Application\Command\Film;

    class FindFilmCommand
    {
        private $allFilms;
        private $filmById;
        private $filmByTitle;

        public function __construct(bool $allFilms, bool $filmById, $filmByTitle)
        {
            $this -> $allFilms      = $allFilms;
            $this -> $filmById      = $filmById;
            $this -> $filmByTitle   = $filmByTitle;
        }

        public function allFilms():bool
        {
            return $this -> allFilms;
        }

    }