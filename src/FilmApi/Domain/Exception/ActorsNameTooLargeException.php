<?php
namespace FilmApi\Domain\Exception;
class ActorsNameTooLargeException extends InvalidArgumentException
{
    public static function empty()
    {
        return new static("The Actor's name it's too large.");
    }
}

