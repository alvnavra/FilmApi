<?php 
    namespace FilmApi\Domain\Events;
    use Symfony\Component\EventDispatcher\Event;
    use FilmApi\Domain\Actor;

    /* Soy consciente de que esta clase no sigue la nomenclatura en pasado. Pero las búsquedas son la excepción a la regla de los eventos
       como algo que se ejecuta después de una acción. Primero tenemos que asegurarnos de que no esté en caché y, posteriormente,
       buscaremos en base de datos*/ 
       
    class FindingActorOnCacheById extends Event
    {
        /** @var id */
        private $id;
        private $actor;


        public function __construct(int $id)
        {
            $this -> id = $id;
        }

        public function id()
        {
            return $this -> id;
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