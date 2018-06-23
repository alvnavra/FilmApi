<?php 
    namespace FilmApiBundle\Event;
    use Symfony\Component\EventDispatcher\Event;
    use FilmApi\Domain\Actor;

    class ActorEvent extends Event
    {
        /** @var Actor */
        private $actor;

        public function __construct(Actor $actor)
        {
            $this -> actor = $actor;
        }

        public function actor()
        {
            return $this -> actor;
        }
    }