<?php
    namespace FilmApi\Application\Comand\Film;

    class CreateFilmCommand
    {
        private $title;
        private $descripton;
        private $idActor;

        public function __consruct(int $id, string $title, string $descripton, int $idActor)
        {
            $this -> title          = $title;
            $this -> description    = $descripton;
            $this -> idActor        = $idActor;
        }
        public function title():string
        {
            return $this -> title;
        }

        public function description():string
        {
            return $this -> description;
        }

        public function idActor():int
        {
            return $this -> idActor;
        }
    }