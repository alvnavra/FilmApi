<?php
    namespace FilmApiBundle\Controller;

    use FilmApi\Application\Command\Actor\CreateActorCommand;
    use FilmApi\Domain\Exception\BadOperationException;
    use FilmApi\Domain\Exception\InvalidArgumentException;
    use FilmApi\Domain\Exception\RepositoryException;
    use FilmApi\Domain\Actor;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;

    use FilmApiBundle\Event\ActorEvent;
    use FilmApiBundle\Event\ActorIdEvent;
    use FilmApiBundle\Event\ActorNameEvent;
    use FilmApiBundle\EventListener\ActorListener;

    class ActorController extends Controller
    {
        public function createActorAction(Request $request)
        {
            $jsonActorName = $request -> get('name');
            $name = filter_var($jsonActorName,FILTER_SANITIZE_STRING);
            var_dump($name);

            $command = new CreateActorCommand($name);
            $handler = $this -> get('filmapi.command_handler.createActor');
            

            try
            {
                $actor = $handler -> handle($command);
                $this -> end();

                //Como ya lo he grabado, lanzo el evento para que se guarde en la caché
                // Tal y como se puede ver, un evento no es más que un servicio. De hecho,
                // se podría decir que un servicio no deja de ser un evento.
                $actorEvent = new ActorEvent($actor);
                $dispatch = $this -> get('event_dispatcher') -> dispatch('actor.created', $actorEvent);

                return new JsonResponse(
                    ['success' => 'Actor correctly created', 'actor' => $actor->toArray()],
                    200
                );                
            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }
        }

        public function deleteActorAction(Request $request)
        {

            $jsonActorName = $request -> get('name');
            $name = filter_var($jsonActorName,FILTER_SANITIZE_STRING);

            $command = new CreateActorCommand($name);
            $handler = $this -> get('filmapi.command_handler.deleteActor');
            try
            {
                $actor = $handler -> handle($command);
                $this -> end();

                $actorEvent = new ActorEvent($actor);
                $dispatch = $this -> get('event_dispatcher') -> dispatch('actor.removed', $actorEvent);

                return new JsonResponse(
                    ['success' => "Actor [$name] correctly deleted"],
                    200
                );                
            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }
        
        }

        public function findActorByNameAction(Request $request)
        {
           
            try
            {
                $jsonActorName = $request -> query -> get('name');
                $name = filter_var($jsonActorName,FILTER_SANITIZE_STRING);

                $actorNameEvent = new ActorNameEvent($name);
                $dispatch = $this -> get('event_dispatcher') -> dispatch('actor.find_by_name', $actorNameEvent);
                $actor = $dispatch->actor();
                if ( $actor == NULL)
                {
                    $handler = $this -> get('filmapi.command_handler.findActorByName');
                    $actor = $handler -> handle($name);
                    $actorEvent = new ActorEvent($actor);
                    $dispatch = $this -> get('event_dispatcher') -> dispatch('actor.created', $actorEvent);    
                }
    
                return new JsonResponse(
                ['success' => 'Actor Found', 'actor' => $actor->toArray()],
                    200
                );
                

            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }

        }
        

        public function findActorByIdAction(Request $request)
        {           
            try
            {
                $jsonActorId = $request -> query -> get('id');
                $id = (int)$jsonActorId;
                $actorIdEvent = new ActorIdEvent($id);
                $dispatch = $this -> get('event_dispatcher') -> dispatch('actor.find_by_id', $actorIdEvent);
                $actor = $dispatch->actor();
                if ( $actor == NULL)
                {
                    $handler = $this -> get('filmapi.command_handler.findActorById');
                    $actor = $handler -> handle($id);
                    $actorEvent = new ActorEvent($actor);
                    $dispatch = $this -> get('event_dispatcher') -> dispatch('actor.created', $actorEvent);    
                }
    
                return new JsonResponse(
                ['success' => 'Actor Found', 'actor' => $actor->toArray()],
                    200
                );

                /*$handler = $this -> get('filmapi.command_handler.findActorById');
                $actor = $handler -> handle($id);
                return new JsonResponse(
                    ['success' => 'Actor Found', 'actor' => $actor->toArray()],
                    200
                );*/
                

            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }

        }

        public function findAllActorsAction(Request $request)
        {
            try
            {
                $handler = $this -> get('filmapi.command_handler.findAllActors');
                $actors = $handler -> handle();
                $this -> end();
                return new JsonResponse(
                    ['success' => 'All Actors on the DB', 'actors' => $actors],
                    200
                );                

            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }

        }

        private function end()
        {
            $this->get('doctrine.orm.default_entity_manager')->flush();
        }
    }

