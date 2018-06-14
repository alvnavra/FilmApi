<?php
    namespace FilmApi\Domain\Exception;
    use Throwable;
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