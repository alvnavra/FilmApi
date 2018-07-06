<?php
    namespace FilmApi\Application\CommandHandler\Actor;

    use FilmApi\Application\Command\Actor\ActorManager;
    use FilmApi\Domain\Actor;
    use FilmApi\Domain\Repository\ActorRepository;
    use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
    use FilmApi\Domain\Events\ActorWasDeletedEvent;


    class DeleteActorHandler
    {
        private $actorRepository;
        private $dispatcher;

        public function __construct(ActorRepository $actorRepository, TraceableEventDispatcher $dispatcher)
        {
            $this -> actorRepository = $actorRepository;
            $this -> dispatcher = $dispatcher;
        }

        public function handle(ActorManager $command):Actor
        {
            $actor = Actor::create($command -> name());
            $this -> actorRepository -> delete($actor);
            $actorEvent = new ActorWasDeletedEvent($actor);
            $this -> dispatcher -> dispatch('actor.was.deleted',$actorEvent);
            return $actor;
        }
    }