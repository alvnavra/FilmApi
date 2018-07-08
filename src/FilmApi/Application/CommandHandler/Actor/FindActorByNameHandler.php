<?php
    namespace FilmApi\Application\CommandHandler\Actor;
    use FilmApi\Domain\Repository\ActorRepository;
    use FilmApi\Application\Command\Actor\ActorManager;
    use FilmApi\Domain\Events\FindingActorOnCacheByName;
    use FilmApi\Domain\Events\ActorWasCreatedEvent;
    use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;    

    Class FindActorByNameHandler
    {
        private $actorRepository;
        private $dispatcher;

        public function __construct(ActorRepository $actorRepository, TraceableEventDispatcher $dispatcher)
        {
            $this -> actorRepository = $actorRepository;
            $this -> dispatcher = $dispatcher;
        }

        public function handle(ActorManager $command)
        {
            $name = $command -> name();
            /* Lo primero que hay que hacer es comprobar si el actor está en caché. Pk, si es así, no hace
               falta llamar al decorador */
            $findingOnCacheActorEvent = new FindingActorOnCacheByName($name);
            $dispatch = $this->dispatcher -> dispatch('actor.find_by_name', $findingOnCacheActorEvent);     
            $actor = $dispatch -> actor();
            if ($actor == NULL)
            {
               $actor =  $this -> actorRepository -> findActorByNameOrError($name);
               $actorEvent = new ActorWasCreatedEvent($actor);
               $this -> dispatcher -> dispatch('actor.was.created',$actorEvent);
            }
            return $actor;
        }
    }