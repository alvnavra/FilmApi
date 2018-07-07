<?php
    namespace FilmApiBundle\Controller;

    use FilmApi\Application\Command\Film\FilmManager;
    use FilmApi\Application\Command\Film\FilmTitleManager;
    use FilmApi\Application\Command\Film\FilmIdManager;
    use FilmApi\Application\Command\Actor\ActorManager;
    use FilmApi\Domain\Exception\BadOperationException;
    use FilmApi\Domain\Exception\InvalidArgumentException;
    use FilmApi\Domain\Exception\RepositoryException;
    use FilmApi\Domain\Film;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;    

    Class FilmController extends Controller
    {
        public function createFilmAction(Request $request)
        {
            $jsonRequestBody = json_decode($request->getContent(),true);
            $name = filter_var($jsonRequestBody['name'] ?? '',FILTER_SANITIZE_STRING);
            $title = filter_var($jsonRequestBody['title'] ?? '',FILTER_SANITIZE_STRING);
            $description = filter_var($jsonRequestBody['description'] ?? '',FILTER_SANITIZE_STRING);

            $command = new ActorManager($name);
            $actorHandler = $this -> get('filmapi.command_handler.findActorByName');
            $actor = $actorHandler -> handle($command);

            $command = new FilmManager($title, $description, $actor);
            $handler = $this -> get('filmapi.command_handler.createFilm');

            try
            {
                $film = $handler -> handle($command, $this -> get('event_dispatcher'));
                $this -> end();
                return new JsonResponse(
                ['success' => 'Film correctly created', 'film' => $film->toArray()],
                    200
                );                

            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }


        }

        public function updateFilmAction(Request $request)
        {
            $jsonRequestBody = json_decode($request->getContent(),true);
            $name = filter_var($jsonRequestBody['name'] ?? '',FILTER_SANITIZE_STRING);

            $command = new ActorManager($name);
            $actorHandler = $this -> get('filmapi.command_handler.findActorByName');
            $actor = $actorHandler -> handle($command);

            $title = filter_var($jsonRequestBody['title'] ?? '',FILTER_SANITIZE_STRING);
            $description = filter_var($jsonRequestBody['description'] ?? '',FILTER_SANITIZE_STRING);
            $command = new FilmManager($title, $description, $actor);
            $handler = $this -> get('filmapi.command_handler.updateFilm');

            try
            {
                $film = $handler -> handle($command, $this -> get('event_dispatcher'));
                $this -> end();
                return new JsonResponse(
                ['success' => "Film [$title] correctly updated"],
                    200
                );                

            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }            

        }        

        public function deleteFilmAction(Request $request)
        {

            try
            {
                $jsonRequestBody = json_decode($request->getContent(),true);
                $title = filter_var($jsonRequestBody['title'] ?? '',FILTER_SANITIZE_STRING);
                $command = new FilmTitleManager($title);
                $handler = $this -> get('filmapi.command_handler.deleteFilm');
                $film = $handler -> handle($command);
                $this -> end();
                return new JsonResponse(
                ['success' => "Film [$title] correctly deleted"],
                    200
                );                

            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }


        }

        public function findFilmByTitleAction(Request $request)
        {
            try
            {
                $jsonFilmTitle = $request -> get('title');                
                $title = filter_var($jsonFilmTitle,FILTER_SANITIZE_STRING);
                $command = new FilmTitleManager($title);     
                $handler = $this -> get('filmapi.command_handler.findFilmByTitle');
                $film = $handler -> handle($command);
                $this -> end();                   
                return new JsonResponse(
                ['success' => 'Film Found', 'film' => $film ->toArray()],
                    200
                );
            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }
        }
        
        public function findFilmByIdAction(Request $request, bool $web=false)
        {
            try
            {
                $jsonFilmId = $request -> get('id');                
                $id = (int)$jsonFilmId;
                $command = new FilmIdManager($id);     
                $handler = $this -> get('filmapi.command_handler.findFilmById');
                $film = $handler -> handle($command);
                $this -> end();  
                if ($web == false)
                {
                    return new JsonResponse(
                    ['success' => 'Film Found', 'film' => $film ->toArray()],
                        200
                    );
                }
                else
                {
                    return $this -> render(
                        'filmlist.html.twig',
                        array(
                            'film' => $film,
                            'locale' => $request -> getLocale()
                        )
                    );

                }
            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }

        }

        public function findAllFilmsAction(Request $request)
        {
            try
            {
                $handler = $this -> get('filmapi.command_handler.findAllFilms');
                $films = $handler -> handle();
                $this -> end();
                return new JsonResponse(
                    ['success' => 'All Films on the DB', 'films' => $films],
                    200
                );                

            }
            catch (InvalidArgumentException $e) {
                return new JsonResponse(['error' => $e->getMessage()], 400);
            } catch (RepositoryException $e) {
                return new JsonResponse(['error' => 'An application error has occurred'], 500);
            }
        }

        public function findFilmByIdWebAction(Request $request)
        {
            return $this -> findFilmByIdAction($request, true);
        }

        private function end()
        {
            $this->get('doctrine.orm.default_entity_manager')->flush();
        }
    }