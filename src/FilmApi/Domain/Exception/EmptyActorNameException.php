<?php
namespace FilmApi\Domain\Exception;
class EmptyActorNameException extends InvalidArgumentException
{
    public static function empty()
    {
        return new static("The Actor's name must be specified");
    }
}

