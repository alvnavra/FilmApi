<?php
    namespace FilmApi\Application\CommandHandler\Actor;
    use FilmApi\Domain\Repository\ActorRepository;
    use FilmApi\Application\Command\Actor\IdActorManager;
    use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;    
    use FilmApi\Domain\Events\ActorWasCreatedEvent;
    use FilmApi\Domain\Events\FindingActorOnCacheById;

    Class FindActorByIdHandler
    {
        private $actorRepository;
        private $dispatcher;

        public function __construct(ActorRepository $actorRepository,TraceableEventDispatcher $dispatcher)
        {
            $this -> actorRepository = $actorRepository;
            $this -> dispatcher = $dispatcher;
        }

        public function handle(IdActorManager $command)
        {
            $id = $command -> id();
            $findingOnCacheActorEvent = new FindingActorOnCacheById($id);
            $dispatch = $this -> dispatcher -> dispatch('actor.find_by_id', $findingOnCacheActorEvent);
            $actor = $dispatch -> actor();
            if ($actor == NULL)
            {
                $actor = $this -> actorRepository -> findActorByIdOrError($id);
                $actorEvent = new ActorWasCreatedEvent($actor);
                $this -> dispatcher -> dispatch('actor.was.created',$actorEvent); 
            }
            return $actor;
        }
    }