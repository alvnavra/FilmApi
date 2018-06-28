<?php
namespace FilmApi\Domain\Exception\Film;
use Throwable;
use FilmApi\Domain\Exception\BadOperationException;

class UnknownFilmException extends BadOperationException
{
    public $filmId;
    public $filmTitle;
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
    public static function withFilmTitle(string $title):self
    {
        $e = new static("Film with title [$title] doesn't exist");
        $e->filmTitle = $title;
        return $e;
    }    
}