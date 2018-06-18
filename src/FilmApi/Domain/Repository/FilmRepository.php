<?php
    namespace FilmApi\Domain\Repository;

    use FilmApi\Domain\Film;
    use FilmApi\Domain\Actor;

    interface FilmRepository
    {
        public function save(Film $film):void;
        public function update(Film $film):void;
        public function delete(Film $film):void;
        public function findFilmByIdOrError(int $id):Film;
        public function findFilmByTitleOrError(string $title):Film;
        public function findAllFilms():array;
        public function findFilmsByActor(Actor $actor):array;
    }