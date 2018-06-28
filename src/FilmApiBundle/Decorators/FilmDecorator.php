<?php
    namespace FilmApiBundle\Decorators;
    use FilmApiBundle\Repository\MySQLFilmRepository;
    use FilmApi\Domain\Repository\FilmRepository;
    use FilmApi\Domain\Film;
    use FilmApi\Domain\Actor;
    use FilmApiBundle\Event\FilmEvent;
    use FilmApiBundle\Event\FilmTitleEvent;
    use Symfony\Component\EventDispatcher\EventDispatcher;
    use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;

    class FilmDecorator implements FilmRepository
    {
        private $mySQL;
        private $dispatcher;

        public function __construct(MySQLFilmRepository $mysql,  TraceableEventDispatcher $dispatcher)
        {
            $this -> mySQL = $mysql;
            $this -> dispatcher = $dispatcher; 
        }

        public function save(Film $film):void
        {
            $this -> mySQL -> save($film);            
            $FilmEventEvent = new FilmEvent($film);
            $dispatch = $this->dispatcher -> dispatch('film.created', $FilmEventEvent);
        }

        public function delete (string $title):Film
        {
            $film = $this -> mySQL -> delete($title);
            $FilmEventEvent = new FilmEvent($film);
            $dispatch = $this->dispatcher -> dispatch('film.deleted', $FilmEventEvent);
            return $film;
        }

        public function update (Film $film):Film
        {
            $oldFilm = $this -> mySQL -> update($film);
            $FilmEventEventDelete = new FilmEvent($oldFilm);
            $dispatch = $this->dispatcher -> dispatch('film.deleted', $FilmEventEventDelete);
            $FilmEventEvent = new FilmEvent($film);
            $dispatch = $this->dispatcher -> dispatch('film.created', $FilmEventEvent);
            return $film;

        }

        public function findFilmByTitleOrError(string $title):Film
        {
            $filmEventTitle = new FilmTitleEvent($title);         
            $dispatch = $this->dispatcher -> dispatch('film.find_by_title', $filmEventTitle);     
            $film = $dispatch->film();
            if ( $film == NULL)
            {
                #echo "En BD";
                $film = $this -> mySQL -> findFilmByTitleOrError($title);
                $FilmEvent = new FilmEvent($film);
                $dispatch = $this->dispatcher -> dispatch('film.created', $FilmEvent);
            }
            var_dump($film);
            return $film;

        }

        public function findFilmByIdOrError(int $id):Film
        {return null;}
        

        public function findAllFilms():array
        {return [];}


    }


