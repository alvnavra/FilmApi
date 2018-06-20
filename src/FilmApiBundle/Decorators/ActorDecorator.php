<?php
    namespace FilmApiBundle\Decorators;
    use FilmApiBundle\Repository\MySQLActorRepository;
    use FilmApi\Domain\Repository\ActorRepository;
    use FilmApi\Domain\Actor;
    use Psr\Cache\CacheItemPoolInterface;

    class ActorDecorator implements ActorRepository
    {
        private $mySQL;
        private $cache;

        public function __construct(MySQLActorRepository $mysql, CacheItemPoolInterface $cacheItemPoolInterface)
        {
            $this -> mySQL = $mysql;
            $this -> cache = $cacheItemPoolInterface;
        }

        public function save(Actor $actor):void
        {
            $this -> mySQL -> save($actor);
        }

        public function update(Actor $actor):void
        {
            $actorOld = $this -> findActorByIdOrError($actor->id());
            $this -> mySQL -> update($actor);
            $this -> cache -> clear($actor -> id());
            $this -> cache -> clear($actorOld -> name());
        }

        public function delete(Actor $actor):void
        {
            $this -> mySQL -> delete($actor);
            $this -> cache -> clear($actor -> name());
        }


        public function findActorByNameOrError(string $name):Actor
        {
            $item = $this -> cache -> getItem('Actor_'.$name);
            if (!$item->isHit()) 
            {
                var_dump('Estoy en la BD');
                $actor = $this -> mySQL -> findActorByNameOrError($name);
                $item -> set($actor);
                $this -> cache -> save($item);
            }
            else
            {
                var_dump('Estoy en la cache');
                $actor = $item -> get();
            }

            return $actor;            
        }

        public function findActorByIdOrError(int $id):Actor
        {
            $item = $this -> cache -> getItem('Actor_'.(string)$id);
            if (!$item->isHit()) 
            {
                var_dump('Estoy en la BD');
                $actor = $this -> mySQL -> findActorByIdOrError($id);
                $item -> set($actor);
                $this -> cache -> save($item);
            }
            else
            {
                var_dump('Estoy en la cache');
                $actor = $item -> get();
            }

            return $actor;
        }

        public function findAllActors():array
        {
            return $this -> mySQL -> findAllActors();
        }

    }