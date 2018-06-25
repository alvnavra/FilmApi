<?php
    namespace FilmApiBundle\Decorators;
    use FilmApiBundle\Repository\MySQLActorRepository;
    use FilmApi\Domain\Repository\ActorRepository;
    use FilmApi\Domain\Actor;
    use FilmApiBundle\Event\ActorEvent;
    use FilmApiBundle\Event\ActorIdEvent;
    use FilmApiBundle\Event\ActorNameEvent;
    use FilmApiBundle\EventListener\ActorListener;
    use Symfony\Component\EventDispatcher\EventDispatcher;
    use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;

    class ActorDecorator implements ActorRepository
    {
        private $mySQL;
        private $dispatcher;

        public function __construct(MySQLActorRepository $mysql,  TraceableEventDispatcher $dispatcher)
        {
            $this -> mySQL = $mysql;
            $this -> dispatcher = $dispatcher; 
        }

        public function save(Actor $actor):void
        {
            $this -> mySQL -> save($actor);
            $actorGuardar = $this -> mySQL -> findActorByNameOrError($actor->name());
            $actorEvent = new ActorEvent($actorGuardar);
            $dispatch = $this->dispatcher -> dispatch('actor.created', $actorEvent);
        }

        public function delete(Actor $actor):void
        {
            $this -> mySQL -> delete($actor);
            $actorEliminar = $this -> mySQL -> findActorByNameOrError($actor->name()); 
            $actorEvent = new ActorEvent($actorEliminar);
            $dispatch = $this->dispatcher -> dispatch('actor.removed', $actorEvent);           
        }


        public function findActorByNameOrError(string $name):Actor
        {   
            $actorEventName = new ActorNameEvent($name);         
            $dispatch = $this->dispatcher -> dispatch('actor.find_by_name', $actorEventName);     
            $actor = $dispatch->actor();
            if ( $actor == NULL)
            {
                #echo "En BD";
                $actor = $this -> mySQL -> findActorByNameOrError($name);
                $actorEvent = new ActorEvent($actor);
                $dispatch = $this->dispatcher -> dispatch('actor.created', $actorEvent);
            }
            return $actor;
        }

        public function findActorByIdOrError(int $id):Actor
        {
            $actorIdEvent = new ActorIdEvent($id);
            $dispatch = $this -> dispatcher -> dispatch('actor.find_by_id', $actorIdEvent);
            $actor = $dispatch->actor();
            if ( $actor == NULL)
            {
                $actorEvent = new ActorEvent($actor);
                $dispatch = $this -> get('event_dispatcher') -> dispatch('actor.created', $actorEvent);    
            }

            $actor = $this -> mySQL -> findActorByIdOrError($id);
            return $actor;
        }

        public function findAllActors():array
        {
            return $this -> mySQL -> findAllActors();
        }

    }