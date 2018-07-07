<?php 
    namespace FilmApi\Domain\Events;
    use Symfony\Component\EventDispatcher\Event;
    use FilmApi\Domain\Film;

    class FindingFilmOnCacheById extends Event
    {
        /** @var Id */
        private $id;
        private $film;


        public function __construct(int $id)
        {
            $this -> id = $id;
        }

        public function id()
        {
            return $this -> id;
        }

        public function addFilm(Film $film)
        {
            $this -> film = $film;
        }

        public function film()
        {
            return $this -> film;
        }
    }