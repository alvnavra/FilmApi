<?php
    namespace FilmApiBundle\Decorators;
    use FilmApiBundle\Repository\MySQLActorRepository;
    use FilmApi\Domain\Repository\ActorRepository;
    use FilmApi\Domain\Actor;

    class ActorDecorator implements ActorRepository
    {
        private $mySQL;

        public function __construct(MySQLActorRepository $mysql)
        {
            $this -> mySQL = $mysql;
        }

        public function save(Actor $actor):void
        {
            $this -> mySQL -> save($actor);
        }

        public function delete(Actor $actor):void
        {
            $this -> mySQL -> delete($actor);
        }


        public function findActorByNameOrError(string $name):Actor
        {   
            $actor = $this -> mySQL -> findActorByNameOrError($name);
            return $actor;
        }

        public function findActorByIdOrError(int $id):Actor
        {
            $actor = $this -> mySQL -> findActorByIdOrError($id);
            return $actor;
        }

        public function findAllActors():array
        {
            return $this -> mySQL -> findAllActors();
        }

    }