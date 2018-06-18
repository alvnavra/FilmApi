<?php
    namespace FilmApi\Domain;

    use FilmApi\Domain\Exception\Actor\InvalidActorNameException;

    class Actor
    {
        private const MAX_NAME_LENGTH = 100;
        private $id;
        private $name;

        private function __construct(string $name)
        {
            $this -> validateName($name);
            $this -> name = filter_var($name,FILTER_SANITIZE_STRING);
        }

        public static function create(string $name):self
        {
            return new self($name);
        }

        private function validateName(string $name):void
        {
            if ($name === '') throw InvalidActorNameException::empty();
            $nameLength = mb_strlen($name);
            if ($nameLength > self::MAX_NAME_LENGTH) 
                throw InvalidActorNameException::ofLength($nameLength,
                                                          self::MAX_NAME_LENGTH);
        }

        public function id():int
        {
            return $this -> id;
        }

        public function name():string
        {
            return $this->name;
        }

        public function toArray():array
        {
            return [
                'id'    => $this ->id(),
                'name'  => $this ->name()
            ];
        }
    }
