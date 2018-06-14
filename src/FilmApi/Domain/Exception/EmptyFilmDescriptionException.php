<?php
namespace FilmApi\Domain\Exception;
class EmptyFilmDescriptionException extends InvalidArgumentException
{
    public static function empty()
    {
        return new static("The Films's description must be specified");
    }
}

