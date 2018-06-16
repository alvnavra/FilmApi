<?php
namespace FilmApi\Domain\Exception\Film;
use Throwable;
use BadOperationException;
class UnknownFilmException extends BadOperationException
{
    public $filmId;
    private function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    public static function withFilmId(int $id):self
    {
        $e = new static("Film with id [$id] doesn't exist");
        $e->FilmId = $id;
        return $e;
    }
}