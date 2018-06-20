<?php
namespace FilmApi\Domain\Exception\Actor;
use Throwable;
use FilmApi\Domain\Exception\BadOperationException;
class UnknownActorException extends BadOperationException
{
    public $actorId;
    private function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    public static function withActorId(int $id):self
    {
        $e = new static("Actor with id [$id] doesn't exist");
        $e->actorIdId = $id;
        return $e;
    }

    public static function withActorName(string $name):self
    {
        $e = new static("Actor with name [$name] doesn't exist");
        $e->actorName = $name;
        return $e;
    }

}