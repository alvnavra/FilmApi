<?php
    namespace FilmApi\Application\Command\Film;
    use FilmApi\Domain\Actor;

    class FilmManager
    {
        private $title;
        private $descripton;
        private $actor;

        public function __construct(string $title, string $descripton, Actor $actor)
        {
            $this -> title          = $title;
            $this -> description    = $descripton;
            $this -> actor          = $actor;

        }
        public function title():string
        {
            return $this -> title;
        }

        public function description():string
        {
            return $this -> description;
        }

        public function actor():Actor
        {
            return $this -> actor;
        }

        public function addActor(Actor $actor)
        {
            $this -> actor = $actor;
        }
    }