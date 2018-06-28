<?php
    namespace FilmApiBundle\Repository;

    use FilmApi\Domain\Exception\RepositoryException;
    use FilmApi\Domain\Exception\Film\UnknownFilmException;
    use FilmApi\Domain\Film;
    use FilmApi\Domain\Actor;
    use FilmApi\Domain\Repository\FilmRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Exception;

    class MySQLFilmRepository 
    {
        private $em;

        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->em = $entityManager;
        }

        public function save(Film $film) : void
        {
            try 
            {          
                    $actorRepository = $this -> em -> getRepository(Actor::class);
                    $entityActor = $actorRepository -> findOneBy(['id'=>$film->actor()->id()]);
                    $film -> addActor($entityActor);
                    $this -> em -> persist($film);
                    $this -> em -> flush();
    
            }            
            catch(Exception $e)
            {
                throw RepositoryException::withError($e);
            }

        }

        public function delete(string $title):Film {
            $film = $this -> findFilmByTitleOrError($title);
            $this -> em -> remove($film);
            return $film;
        }

        public function update(Film $film):Film {
            try
            {
                $actorName = $film->actor()->name();                
                $actorRepository = $this -> em -> getRepository(Actor::class);
                echo $actorName;
                $entityActor = $actorRepository -> findOneBy(['name'=>$film->actor()->name()]);
                echo "Hemos encontrado el actor".$entityActor->name();
                $entityFilm = $this -> findFilmByTitleOrError($film -> title());
                $oldFilm = $entityFilm; //Este lo devolveremos para elminarlo de la caché
                $entityFilm -> addDescription($film -> description());
                $entityFilm -> addActor($entityActor);
                $this -> em -> persist($entityFilm);
                $this -> em -> flush();
                return $oldFilm;
            }
            catch(Exception $e)
            {
                throw RepositoryException::withError($e);
            }
            
        }

        public function findFilmByIdOrError(int $id):Film 
        { 
            $repository = $this -> em -> getRepository(Film::class);
            $film = $repository -> findOneBy(['id' => $id]);
            if ($film == null)
            {
                throw UnknownFilmException::withFilmId($id);
            }
            return $film;
        }
        
        public function findFilmByTitleOrError(string $title):Film
        {
            $repository = $this -> em -> getRepository(Film::class);
            $film = $repository -> findOneBy(['title' => $title]);
            if ($film == null)
            {
                throw UnknownFilmException::withFilmTitle($title);
            }
            return $film;
        }
        public function findAllFilms():array
        {
            try
            {
                $repository = $this -> em -> getRepository(Film::class);
                $films = $repository -> findAll();
                $arrayOfFilms = [];
                foreach ($films as $film)
                {
                    $arrayOfFilms[$film->title()] = $film->toArray();
                }
                return $arrayOfFilms;
            }
            catch (Exception $e)
            {
                throw RepositoryException::withError($e);
            }


        }

    }