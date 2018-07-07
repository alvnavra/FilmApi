<?php
    namespace FilmApiBundle\Decorators;
    use FilmApiBundle\Repository\MySQLFilmRepository;
    use FilmApi\Domain\Repository\FilmRepository;
    use FilmApi\Domain\Film;

    class FilmDecorator implements FilmRepository
    {
        private $mySQL;

        public function __construct(MySQLFilmRepository $mysql)
        {
            $this -> mySQL = $mysql;
        }

        public function save(Film $film):void
        {
            $this -> mySQL -> save($film);            
        }

        public function delete (string $title):Film
        {
            $film = $this -> mySQL -> delete($title);
            return $film;
        }

        public function update (Film $film):Film
        {
            $oldFilm = $this -> mySQL -> update($film);
            return $film;
        }

        public function findFilmByTitleOrError(string $title):Film
        {
            $film = $this -> mySQL -> findFilmByTitleOrError($title);
            return $film;
        }

        public function findFilmByIdOrError(int $id):Film
        {
            $film = $this -> mySQL -> findFilmByIdOrError($id);
            return $film;
        }
        

        public function findAllFilms():array
        {
            return $this -> mySQL -> findAllFilms();
        }



    }


