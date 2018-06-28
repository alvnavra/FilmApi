<?php
    namespace FilmApi\Domain\Repository;

    use FilmApi\Domain\Film;
    use FilmApi\Domain\Actor;

    interface FilmRepository
    {
        public function save(Film $film):void;
        public function update(Film $film):Film;
        public function delete(string $title):Film;
        public function findFilmByIdOrError(int $id):Film;
        public function findFilmByTitleOrError(string $title):Film;
        public function findAllFilms():array;
    }