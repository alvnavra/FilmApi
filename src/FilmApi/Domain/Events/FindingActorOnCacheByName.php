<?php 
    namespace FilmApi\Domain\Events;
    use Symfony\Component\EventDispatcher\Event;
    use FilmApi\Domain\Actor;

    /* Soy consciente de que esta clase no sigue la nomenclatura en pasado. Pero las búsquedas son la excepción a la regla de los eventos
       como algo que se ejecuta después de una acción. Primero tenemos que asegurarnos de que no esté en caché y, posteriormente,
       buscaremos en base de datos*/ 
       
    class FindingActorOnCacheByName extends Event
    {
        /** @var name */
        private $name;
        private $actor;


        public function __construct(string $name)
        {
            $this -> name = $name;
        }

        public function name()
        {
            return $this -> name;
        }

        public function addActor(Actor $actor)
        {
            $this -> actor = $actor;
        }

        public function actor()
        {
            return $this -> actor;
        }
    }