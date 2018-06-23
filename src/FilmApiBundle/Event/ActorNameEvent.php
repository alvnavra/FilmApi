<?php 
    namespace FilmApiBundle\Event;
    use Symfony\Component\EventDispatcher\Event;
    use FilmApi\Domain\Actor;

    class ActorNameEvent extends Event
    {
        /** @var name */
        private $name;
        private $actor;


        public function __construct(string $name)
        {
            $this -> name = $name;
        }

        public function name()
        {
            return $this -> name;
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