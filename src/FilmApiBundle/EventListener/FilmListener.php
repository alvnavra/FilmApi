<?php
    namespace FilmApiBundle\EventListener;
    use FilmApiBundle\Event\FilmEvent;
    use FilmApiBundle\Event\FilmTitleEvent;
    use FilmApiBundle\Event\FilmIdEvent;
    use Symfony\Component\EventDispatcher\Event;
    use Psr\Cache\CacheItemPoolInterface;

    class FilmListener
    {
        private $cache;

        public function __construct(CacheItemPoolInterface $cacheItemPoolInterface)
        {
            $this -> cache = $cacheItemPoolInterface;
        }

        public function onFilmCreated(Event $event):void
        {
            $film = $event -> film();

            $item = $this -> cache -> getItem("Film_".$film->title());
            if (!$item->isHit())
            {
                $item -> set($film);
                $this -> cache -> save($item);
            }
        }

        public function onFilmDeleted(Event $event):void
        {
            $film = $event -> film();
            $item = $this -> cache -> getItem('Film_'.$film->title());
            if ($item->isHit())
            {
                $this -> cache -> clear($film -> title());
            }

        }

        public function onFilmFindByTitle(FilmTitleEvent $event):FilmTitleEvent
        {
            $title = $event -> title();
            $item = $this -> cache -> getItem('Film_'.$title);
            if ($item -> isHit())
            {
                $event -> addFilm($item -> get());
            }
            return $event;
        }

        public function onFilmFindById(FilmIdEvent $event):FilmIdEvent
        {
            $id = $event -> id();
            $item = $this -> cache -> getItem('Film_'.(string)$id);
            if ($item -> isHit())
            {
                $event -> addActor($item -> get());
            }
            return $event;
        }
    }