<?php
    namespace FilmApiBundle\EventListener;
    use FilmApiBundle\Event\ActorEvent;
    use FilmApiBundle\Event\ActorNameEvent;
    use FilmApiBundle\Event\ActorIdEvent;
    use Symfony\Component\EventDispatcher\Event;
    use Psr\Cache\CacheItemPoolInterface;

    class ActorListener
    {
        private $cache;

        public function __construct(CacheItemPoolInterface $cacheItemPoolInterface)
        {
            $this -> cache = $cacheItemPoolInterface;
        }

        public function onActorCreated(Event $event):void
        {
            $actor = $event -> actor();
            $item = $this -> cache -> getItem('Actor_'.(string)$actor->id());
            /* Si lo estamos creando, el hit debería ser falso siempre. Pero, en todo caso, 
               si ya existiera, no lo volveríamos a cachear */
            if (!$item->isHit())
            {
                $item -> set($actor);
                $this -> cache -> save($item);
            }

            $item = $this -> cache -> getItem('Actor_'.$actor->name());
            /* Este caso es diferente, ya que si se grabasen dos actores con el mismo nombre
             * grabaría en la caché los dos actores usando el id como clave, pero en el caso
             * del nombre, solo grabaría el primero. Con lo cual, una busqueda por nombre
             * siempre devolvería el primero.
             */
            if (!$item->isHit())
            {
                $item -> set($actor);
                $this -> cache -> save($item);
            }
        }

        public function onActorRemoved(Event $event):void
        {
            $actor = $event -> actor();
            $item = $this -> cache -> getItem('Actor_'.$actor->name());
            if ($item->isHit())
            {
                $this -> cache -> clear($actor -> name());
            }

        }

        public function onActorFindByName(ActorNameEvent $event):ActorNameEvent
        {
            $name = $event -> name();
            $item = $this -> cache -> getItem('Actor_'.$name);
            if ($item -> isHit())
            {
                $event -> addActor($item -> get());
            }
            return $event;
        }

        public function onActorFindById(ActorIdEvent $event):ActorIdEvent
        {
            $id = $event -> id();
            $item = $this -> cache -> getItem('Actor_'.(string)$id);
            if ($item -> isHit())
            {
                $event -> addActor($item -> get());
            }
            return $event;
        }
    }