<?php
    namespace FilmApiBundle\Decorators;
    use FilmApiBundle\Repository\MySQLActorRepository;
    use FilmApi\Domain\Repository\ActorRepository;
    use FilmApi\Domain\Actor;

    class ActorDecorator implements ActorRepository
    {
        private $mySQL;
        private $dispatcher;

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
            echo "En BD";
            $actor = $this -> mySQL -> findActorByNameOrError($name);
            return $actor;
        }

        public function findActorByIdOrError(int $id):Actor
        {
            /*$actorIdEvent = new ActorIdEvent($id);
            $dispatch = $this -> dispatcher -> dispatch('actor.find_by_id', $actorIdEvent);
            $actor = $dispatch->actor();
            if ( $actor == NULL)
            {*/
                echo "En BD";
                $actor = $this -> mySQL -> findActorByIdOrError($id);
               /* $actorEvent = new ActorEvent($actor);
                $dispatch = $this -> dispatcher ->dispatch('actor.created', $actorEvent);    
            }*/
            return $actor;
        }

        public function findAllActors():array
        {
            return $this -> mySQL -> findAllActors();
        }

    }