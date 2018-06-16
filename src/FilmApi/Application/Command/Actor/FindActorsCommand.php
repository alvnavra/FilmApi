<?php
    namespace FilmApi\Application\Command\Actor;

    class FindActorsCommand
    {
        private $allActors;
        private $actorById;
        private $actorByName;

        public function __construct(bool $allActors, bool $actorById, bool $actorByName)
        {
            $this -> $allActors     = $allActors;
            $this -> $actorById     = $actorById;
            $this -> $actorByName   = $actorByName;
        }

        public function allActors():bool
        {
            return $this -> allActors;
        }

        public function actorById(): bool
        {
            return $this -> actorById;
        }

        public function actorByName():bool
        {
            return $this -> actorByName;
        }

    }