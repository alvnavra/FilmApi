<?php
    namespace FilmApi\Domain\Repository;

    use FilmApi\Domain\Actor;

    interface ActorRepository
    {
        public function save(Actor $actor):void;
        public function update(Actor $actor):void;
        public function delete(Actor $actor):void;
        public function findActorByNameOrError(string $name):Actor;
        public function findActorByIdOrError(int $id):Actor;
        public function findAllActors():array;
    }