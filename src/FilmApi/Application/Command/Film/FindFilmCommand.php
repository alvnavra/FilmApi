<?php
    namespace FilmApi\Application\Command\Film;

    class FindFilmCommand
    {
        private $allFilms;

        public function __construct(bool $allFilms)
        {
            $this -> $allFilms = $allFilms;
        }

        public function allFilms():bool
        {
            return $this -> allFilms;
        }

    }