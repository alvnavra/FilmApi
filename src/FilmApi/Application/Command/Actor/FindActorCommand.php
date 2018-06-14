<?php
    namespace FilmApi\Application\Command\Actor;

    class FindActorCommand
    {
        private $allActors;

        public function __construct(bool $allActors)
        {
            $this -> $allActors = $allActors;
        }

        public function allActors():bool
        {
            return $this -> allActors;
        }

    }