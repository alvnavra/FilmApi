<?php
    namespace FilmApiBundle\Decorators;
    use FilmApiBundle\Repository\MySQLActorRepository;
    use FilmApi\Domain\Repository\ActorRepository;
    use FilmApi\Domain\Actor;
    use Psr\Cache\CacheItemPoolInterface;

    class ActorDecorator implements ActorRepository
    {
        private $mySQL;

        public function __construct(MySQLActorRepository $mysql, CacheItemPoolInterface $cacheItemPoolInterface)
        {
            $this-> mySQL = $mysql;
        }

        public function save(Actor $actor):void
        {
            $this -> mySQL -> save($actor);
        }

        public function update(Actor $actor):void
        {
            $this -> mySQL -> update($actor);
        }

        public function delete(Actor $actor):void
        {
            $this -> mySQL -> delete($actor);
        }

        public function findActorByNameOrEerror(string $name):Actor
        {
            $pepe = new Actor('pepe');
            return $pepe;
        }
        public function findActorByIdOrError(int $id):Actor
        {
            $pepe = new Actor('pepe');
            return $pepe;

        }
        public function findAllActors():array
        {
            $pepe = new Actor('pepe');            
            return [$pepe];
        }

    }