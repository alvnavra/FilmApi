<?php
    namespace FilmApi\Application\Command\Film;

    class FilmTitleManager
    {
        private $title;

        public function __construct(string $title)
        {
            $this -> title = $title;

        }
        public function title():string
        {
            return $this -> title;
        }
    }