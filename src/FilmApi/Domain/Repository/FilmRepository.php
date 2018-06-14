<?php
    namespace FilmApi\Domain\Repository;

    use FilmApi\Domain\Film;

    interface FilmRepository
    {
        public function save(Film $film):void;
        public function update(Film $film):void;
        public function delete(Film $film):void;
        public function findFilmByIdOrError(int $id):Film;
        public function findFilmByTitleOrError(string $title):Film;
        public function findAllFilms():array;
    }