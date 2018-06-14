<?php
namespace FilmApi\Domain\Exception;
class EmptyFilmTitleException extends InvalidArgumentException
{
    public static function empty()
    {
        return new static("The Films's title must be specified");
    }
}

