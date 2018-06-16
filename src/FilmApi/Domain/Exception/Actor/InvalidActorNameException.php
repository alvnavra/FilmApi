<?php
namespace FilmApi\Domain\Exception\Actor;
use FilmApi\Domain\Exception\InvalidArgumentException;

class InvalidActorNameException extends InvalidArgumentException
{
    public $nameLength;

    public static function ofLength(int $length, int $maxLength)
    {
        $exception = new static("Invalid length [$length] for the name, max length is $maxLength");
        $exception -> $nameLength = $length;
        return $exception;
    }

    public static function empty()
    {
        return new static("The name must be specified");
    }    
}

