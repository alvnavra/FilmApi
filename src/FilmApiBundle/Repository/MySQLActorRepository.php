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
            $this -> save($actor);
        }

        public function delete(Actor $actor):void
        {
            
                $actorBorrar = $this -> findActorByNameOrError($actor->name());
                $this -> em -> remove($actorBorrar);
                $this -> em -> flush();            

        }

        public function findActorByNameOrError(string $name):Actor
        {
            $repository = $this -> em -> getRepository(Actor::class);
            $actor = $repository -> findOneBy(['name' => $name]);
            if ($actor == null)
            {
                throw UnknownActorException::withActorName($name);
            }
            else
            {
                return $actor;
            }
        }
        public function findActorByIdOrError(int $id):Actor
        {
            $repository = $this -> em -> getRepository(Actor::class);
            $actor = $repository -> findOneBy(['id'=>$id]);

            if ($actor == null)
            {
                throw UnknownActorException::withActorId($id);
            }
            else
            {
                
                return $actor;
            }
        }
        
        public function findAllActors():array
        {
            try
            {
                $repository = $this -> em -> getRepository(Actor::class);
                $actors = $repository -> findAll();
                $arrayOfActors = [];
                foreach ($actors as $actor)
                {
                    $arrayOfActors[$actor->name()] = $actor->toArray();
                }
                return $arrayOfActors;
            }
            catch (Exception $e)
            {
                throw RepositoryException::withError($e);
            }


        }
    }

    