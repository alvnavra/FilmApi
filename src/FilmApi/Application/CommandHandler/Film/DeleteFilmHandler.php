<?php
    namespace FilmApi\Application\CommandHandler\Film;

    use FilmApi\Domain\Film;
    use FilmApi\Domain\Repository\FilmRepository;
    use FilmApi\Application\Command\Film\FilmTitleManager;
    use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
    use FilmApi\Domain\Events\FilmWasDeletedEvent;


    class DeleteFilmHandler
    {
        private $filmRepository;
        private $dispatcher;

        public function __construct(FilmRepository $filmRepository, TraceableEventDispatcher $dispatcher)
        {
            $this -> filmRepository = $filmRepository;
            $this -> dispatcher = $dispatcher;
        }

        public function handle(FilmTitleManager $command):void
        {
            $title = $command -> title();
            $film = $this -> filmRepository -> delete($title);
            $filmEvent = new FilmWasDeletedEvent($film);
            $this -> dispatcher -> dispatch('film.was.deleted',$filmEvent);
        }
    }