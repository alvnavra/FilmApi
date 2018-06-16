<?php
    namespace FilmApiBundle\Repository;

    use FilmApi\Domain\Exception\RepositoryException;
    use FilmApi\Domain\Exception\Actor\UnknownActorException;
    use FilmApi\Domain\Actor;
    use FilmApi\Domain\Repository\ActorRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Exception;

    class MySQLActorRepository implements ActorRepository
    {

    }

    