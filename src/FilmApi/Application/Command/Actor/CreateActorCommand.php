<?php
    namespace FilmApi\Application\Comand\Actor;

    class CreateActorCommand
    {
        private $name;

        public function __consruct(string $name)
        {
            $this -> name = $name;
        }

        public function name():string
        {
            return $this -> name;
        }
    }