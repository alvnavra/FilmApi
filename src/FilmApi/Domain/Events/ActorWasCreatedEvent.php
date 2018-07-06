<?php
  namespace FilmApi\Domain\Events;
  use FilmApi\Domain\Actor;
  use Symfony\Component\EventDispatcher\Event;

  class ActorWasCreatedEvent extends Event
  {
      private $actor;
      public function __construct(Actor $actor)
      {
         $this -> actor = $actor;
      }

      public function actor():Actor
      {
          return $this->actor;
      }
  }