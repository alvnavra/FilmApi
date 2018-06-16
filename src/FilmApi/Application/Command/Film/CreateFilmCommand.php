<?php
    namespace FilmApi\Application\Comand\Film;

    class CreateFilmCommand
    {
        private $title;
        private $descripton;

        public function __consruct(int $id, string $title, string $descripton)
        {
            $this -> title          = $title;
            $this -> description    = $descripton;
        }
        public function title():string
        {
            return $this -> title;
        }

        public function description():string
        {
            return $this -> description;
        }
    }