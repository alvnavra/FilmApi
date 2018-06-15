<?php
    namespace FilmApi\Application\Comand\Actor;

    class CreateActorCommand
    {
        private $id;
        private $name;

        public function __consruct(int $id, string $name)
        {
            $this -> id   = $id;
            $this -> name = $name;
        }

        public function id():int
        {
            return $this -> id;
        }
        
        public function name():string
        {
            return $this -> name;
        }
    }