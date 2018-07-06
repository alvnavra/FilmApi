<?php
    namespace FilmApi\Application\Command\Actor;

    class IdActorManager
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