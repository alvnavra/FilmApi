<?php
    namespace FilmApi\Application\Command\Actor;

    class CreateActorCommand
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