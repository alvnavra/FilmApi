<?php
    namespace FilmApi\Domain\Exception\Actor;
    use Throwable;
    use FilmApi\Domain\Exception\BadOperationException;
    class ActorAlreadyExistsException extends BadOperationException
    {
        public $name;
        private function __construct(string $message = "", int $code = 0, Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
        public static function withActorName(string $name):self
        {
            $e = new static("Actor with name [$name] already exists");
            $e->name = $name;
            return $e;
        }
    }