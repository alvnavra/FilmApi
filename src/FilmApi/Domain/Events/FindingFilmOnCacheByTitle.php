<?php 
    namespace FilmApi\Domain\Events;
    use Symfony\Component\EventDispatcher\Event;
    use FilmApi\Domain\Film;

    /* Soy consciente de que esta clase no sigue la nomenclatura en pasado. Pero las búsquedas son la excepción a la regla de los eventos
       como algo que se ejecuta después de una acción. Primero tenemos que asegurarnos de que no esté en caché y, posteriormente,
       buscaremos en base de datos*/ 
       
    class FindingFilmOnCacheByTitle extends Event
    {
        /** @var title */
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