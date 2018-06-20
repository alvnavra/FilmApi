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
            var_dump($name);

            $command = new CreateActorCommand($name);
            $handler = $this -> get('filmapi.command_handler.deleteActor');
            try
            {
                $actor = $handler -> handle($command);
                $this -> end();
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
    
                $handler = $this -> get('filmapi.command_handler.findActorByName');
                $actor = $handler -> handle($name);
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
    
                $handler = $this -> get('filmapi.command_handler.findActorById');
                $actor = $handler -> handle($id);
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

