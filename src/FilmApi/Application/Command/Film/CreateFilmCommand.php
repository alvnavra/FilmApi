<?php
    namespace FilmApi\Application\Comand\Film;

    class CreateFilmCommand
    {
        private $id;
        private $title;
        private $descripton;

        public function __consruct(int $id, string $title, string $descripton)
        {
            $this -> id             = $id;
            $this -> title          = $title;
            $this -> description    = $descripton;
        }

        public function id():int
        {
            return $this -> title;
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