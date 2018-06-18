<?php
    namespace FilmApiBundle\Repository;

    use FilmApi\Domain\Exception\RepositoryException;
    use FilmApi\Domain\Exception\Actor\UnknownActorException;
    use FilmApi\Domain\Actor;
    use FilmApi\Domain\Repository\ActorRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Exception;

    class MySQLActorRepository 
    {
        private $em;

        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->em = $entityManager;
        }

        public function save(Actor $actor):void
        {
            try
            {
                $this -> em -> persist($actor);
            }            
            catch(Exception $e)
            {
                throw RepositoryException::withError($e);
            }
        }

        public function update(Actor $actor):void
        {

        }

        public function delete(Actor $actor):void
        {

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

    