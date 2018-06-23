<?php 
    namespace FilmApiBundle\Event;
    use Symfony\Component\EventDispatcher\Event;
    use FilmApi\Domain\Actor;

    class ActorIdEvent extends Event
    {
        /** @var Id */
        private $id;
        private $actor;

        public function __construct(int $id)
        {
            $this -> id = $id;
        }

        public function id()
        {
            return $this -> id;
        }

        public function addActor(Actor $actor)
        {
            $this -> actor = $actor;
        }

        public function actor()
        {
            return $this -> actor;
        }

    }