<?php
    namespace FilmApi\Application\Command\Actor;

    class ActorManager
    {
        private $name;

        public function __construct(string $name)
        {
            $this -> name = $name;
        }

        public function name():string
        {
            return $this -> name;
        }
    }