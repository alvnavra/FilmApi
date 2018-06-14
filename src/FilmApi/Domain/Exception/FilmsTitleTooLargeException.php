<?php
namespace FilmApi\Domain\Exception;
class FilmsTitleTooLargeException extends InvalidArgumentException
{
    public static function empty()
    {
        return new static("The Film's title it's too large.");
    }
}

