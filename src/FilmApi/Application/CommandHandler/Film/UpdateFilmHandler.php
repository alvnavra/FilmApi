<?php
    namespace FilmApi\Application\CommandHandler\Film;

    use FilmApi\Application\Command\Film\FilmManager;
    use FilmApi\Domain\Film;
    use FilmApi\Domain\Repository\FilmRepository;
    use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
    use FilmApi\Domain\Events\FilmWasDeletedEvent;
    use FilmApi\Domain\Events\FilmWasCreatedEvent;

    class UpdateFilmHandler
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
            $oldFilm = $this->filmRepository-> findFilmByTitleOrError($command->title());
            $film = Film::create($command -> title(),$command -> description(),$command -> actor());            
            $this -> filmRepository -> update($film);
            $oldFilmEvent = new FilmWasDeletedEvent($oldFilm);
            $this -> dispatcher -> dispatch('film.was.deleted',$oldFilmEvent);
            $newFilmEvent = new FilmWasDeletedEvent($film);
            $this -> dispatcher -> dispatch('film.was.created',$newFilmEvent);            
            return $film;
        }
    }