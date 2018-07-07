<?php
  namespace FilmApi\Domain\Events;
  use FilmApi\Domain\Film;
  use Symfony\Component\EventDispatcher\Event;

  class FilmWasDeletedEvent extends Event
  {
      private $film;
      public function __construct(Film $film)
      {
         $this -> film = $film;
      }

      public function film():Film
      {
          return $this->film;
      }
  }