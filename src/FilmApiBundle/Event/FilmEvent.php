<?php 
    namespace FilmApiBundle\Event;
    use Symfony\Component\EventDispatcher\Event;
    use FilmApi\Domain\Film;

    class FilmEvent extends Event
    {
        /** @var Film */
        private $film;

        public function __construct(Film $film)
        {
            $this -> film = $film;
        }

        public function film()
        {
            return $this -> film;
        }
    }    