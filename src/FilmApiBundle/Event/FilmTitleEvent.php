<?php 
    namespace FilmApiBundle\Event;
    use Symfony\Component\EventDispatcher\Event;
    use FilmApi\Domain\Film;

    class FilmTitleEvent extends Event
    {
        /** @var name */
        private $title;
        private $film;


        public function __construct(string $title)
        {
            $this -> title = $title;
        }

        public function title()
        {
            return $this -> title;
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