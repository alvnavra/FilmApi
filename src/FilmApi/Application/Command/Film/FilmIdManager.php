<?php
    namespace FilmApi\Application\Command\Film;

    class FilmIdManager
    {
        private $id;

        public function __construct(int $id)
        {
            $this -> id = $id;

        }
        public function id():int
        {
            return $this -> id;
        }
    }