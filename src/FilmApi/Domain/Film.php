<?php
    namespace FilmApi\Domain;

    use FilmApi\Domain\Exception\Film\InvalidFilmDataException;
    use FilmApi\Domain\Actor;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\Common\Collections\ArrayCollection;

    class Film
    {
        private const MAX_TITLE_LENGTH = 100; // Solo se controla la longitud del título, pk la descripción es de tipo texto. No tiene límites.
        private $id;
        private $title;
        private $description;
        private $actor;

        private function __construct(string $title, string $description, Actor $actor)
        {
            $this -> validateTitle($title);
            $this -> validateDescription($description);
            $this -> title = filter_var($title,FILTER_SANITIZE_STRING);
            $this -> description = filter_var($description,FILTER_SANITIZE_STRING);
            $this -> actor = $actor;
        }

        public static function create(string $title, string $description, Actor $actor):self
        {
            return new self($title, $description, $actor);
        }

        private function validateTitle(string $title):void
        {
            if ($title === '') throw InvalidFilmDataException::empty($title);
            $titleLength = mb_strlen($title);
            if ($titleLength > self::MAX_TITLE_LENGTH) 
                throw InvalidFilmDataException::ofLength($title,
                                                         $titleLength,
                                                         self::MAX_TITLE_LENGTH);
        }

        private function validateDescription(string $description):void
        {
            if ($description === '') throw InvalidFilmDataException::empty($description);
        }


        public function id():int
        {
            return $this -> id;
        }

        public function title():string
        {
            return $this->title;
        }

        public function description():string
        {
            return $this->description;
        }

        public function addActor(Actor $actor):void
        {
            $this -> actor = $actor;
        }

        public function actor():Actor
        {
            return $this->actor;
        }

        public function addDescription(string $description):void
        {
            $this -> description = $description;
        }

        public function toArray():array
        {
            return [
                'id'           => $this ->id(),
                'title'        => $this ->title(),
                'description'  => $this ->description(),
                'actor'        => $this -> actor() -> name()
            ];
        }
    }
