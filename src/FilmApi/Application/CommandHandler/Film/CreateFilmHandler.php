<?php
    namespace FilmApi\Application\CommandHandler\Film;
    use FilmApi\Application\CommandHandler\Actor\FindActorByName;
    use FilmApi\Application\Command\Film\FilmManager;
    use FilmApi\Domain\Film;
    use FilmApi\Domain\Actor;
    use FilmApi\Domain\Repository\FilmRepository;
    use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
    use FilmApi\Domain\Events\FilmWasCreatedEvent;


    class CreateFilmHandler
    {
        private $filmRepository;
        private $dispatcher;

        public function __construct(FilmRepository $filmRepository, TraceableEventDispatcher $dispatcher)
        {
            $this -> filmRepository = $filmRepository;
            $this -> dispatcher = $dispatcher;
        }

        public function handle(FilmManager $command):Film
        {
            $film = Film::create($command -> title(),$command -> description(), $command -> actor());
            $this -> filmRepository -> save($film);
            $filmEvent = new FilmWasCreatedEvent($film);
            $this -> dispatcher -> dispatch('film.was.created',$filmEvent);
            return $film;
        }
    }