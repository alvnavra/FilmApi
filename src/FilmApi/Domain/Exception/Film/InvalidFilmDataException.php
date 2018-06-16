<?php
namespace FilmApi\Domain\Exception\Film;
use FilmApi\Domain\Exception\InvalidArgumentException;
class InvalidFilmDataException extends InvalidArgumentException
{
    public $fieldLength;

    public static function ofLength(string $field, int $length, int $maxLength)
    {
        $exception = new static("Invalid length [$length] for the [$field], max length is $maxLength");
        $exception -> $fieldLength = $length;
        return $exception;
    }

    public static function empty(string $field)
    {
        return new static("The [$field] must be specified");
    }    
}
