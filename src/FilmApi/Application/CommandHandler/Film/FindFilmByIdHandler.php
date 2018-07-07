<?php
    namespace FilmApi\Application\CommandHandler\Film;
    use FilmApi\Domain\Repository\FilmRepository;
    use FilmApi\Domain\Repository\ActorRepository;
    use FilmApi\Application\Command\Film\FilmIdManager;
    use FilmApi\Domain\Events\FindingFilmOnCacheById;
    use FilmApi\Domain\Events\FindingActorOnCacheById;
    use FilmApi\Domain\Events\FilmWasCreatedEvent;
    use FilmApi\Domain\Events\ActorWasCreatedEvent;
    use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;    
    

      class FindFilmByIdHandler
    {
        private $filmRepository;
        private $dispatcher;
        private $actorRepository;


        public function __construct(FilmRepository $filmRepository, ActorRepository $actorRepository, TraceableEventDispatcher $dispatcher)
        {
            $this -> filmRepository = $filmRepository;
            $this -> dispatcher = $dispatcher;
            $this -> actorRepository = $actorRepository;
        }

        public function handle(FilmIdManager $command)
        {
            $id = $command -> id();
            /* Lo primero que hay que hacer es comprobar si el film está en caché. Pk, si es así, no hace
               falta llamar al decorador */
            $findingFilmOnCacheById = new FindingFilmOnCacheById($id);
            $dispatch = $this->dispatcher -> dispatch('film.find_by_id', $findingFilmOnCacheById);     
            $film  = $dispatch -> film();
            if ($film == NULL)
            {
                $film = $this -> filmRepository -> findFilmByIdOrError($id);
                $filmEvent = new FilmWasCreatedEvent($film);
                $this -> dispatcher -> dispatch('film.was.created',$filmEvent);
            }
            else
            {
                /*Todavía no podemos devolver el film, pk lo que nos devuelve es el registro que hay
                  en base de datos, es decir, el film con el identificador del actor. Con lo cual,
                  tenemos que traernos el actor y construir el film */
                $actorId = $film->actor()->id();
                $actorEvent = new FindingActorOnCacheById($actorId);
                $dispatch = $this -> dispatcher -> dispatch('actor.find_by_id', $actorEvent);
                $actor = $dispatch -> actor();
                if ($actor == NULL)
                {
                    $actor = $this -> actorRepository -> findActorByIdOrError($actorId);
                    $actorEvent = new ActorWasCreatedEvent($actor);
                    $dispatch = $this -> dispatcher -> dispatch('actor.was.created', $actorEvent);
                }
                $film -> addActor($actor);
            }



            return $this -> filmRepository -> findFilmByIdOrError($id);
        }

    }