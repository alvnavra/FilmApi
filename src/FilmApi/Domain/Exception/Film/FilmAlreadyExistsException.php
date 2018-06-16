<?php
    namespace FilmApi\Domain\Exception\Film;
    use Throwable;
    use FilmApi\Domain\Exception\BadOperationException;
    class FilmAlreadyExistsException extends BadOperationException
    {
        public $title;
        private function __construct(string $message = "", int $code = 0, Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
        public static function withFilmTitle(string $title):self
        {
            $e = new static("Film with title [$title] already exists");
            $e->title = $title;
            return $e;
        }
    }