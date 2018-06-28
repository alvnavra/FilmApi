<?php
    namespace FilmApiBundle\Controller;

    use FilmApi\Application\Command\Film\FilmManager;
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
            $jsonActorName = $request -> get('name');
            $name = filter_var($jsonActorName,FILTER_SANITIZE_STRING);

            $jsonFilmTitle = $request -> get('title');
            $title = filter_var($jsonFilmTitle,FILTER_SANITIZE_STRING);

            $jsonFilmDescription = $request -> get('description');
            $description = filter_var($jsonFilmDescription,FILTER_SANITIZE_STRING);

            $actorHandler = $this -> get('filmapi.command_handler.findActorByName');
            $actor = $actorHandler -> handle($name);

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
            $jsonActorName = $request -> get('name');
            $name = filter_var($jsonActorName,FILTER_SANITIZE_STRING);

            $jsonFilmTitle = $request -> get('title');
            $title = filter_var($jsonFilmTitle,FILTER_SANITIZE_STRING);

            $jsonFilmDescription = $request -> get('description');
            $description = filter_var($jsonFilmDescription,FILTER_SANITIZE_STRING);

            $actorHandler = $this -> get('filmapi.command_handler.findActorByName');
            $actor = $actorHandler -> handle($name);

            $command = new FilmManager($title, $description, $actor);
            $handler = $this -> get('filmapi.command_handler.updateFilm');

            try
            {
                $film = $handler -> handle($command, $this -> get('event_dispatcher'));
                $this -> end();
                return new JsonResponse(
                ['success' => "Film correctly [$title] updated"],
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
                $jsonFilmTitle = $request -> get('title');                
                $title = filter_var($jsonFilmTitle,FILTER_SANITIZE_STRING);            
                $handler = $this -> get('filmapi.command_handler.deleteFilm');
                $film = $handler -> handle($title);
                $this -> end();
                return new JsonResponse(
                ['success' => "Film correctly [$title] deleted"],
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
            $jsonFilmTitle = $request -> get('title');                
            $title = filter_var($jsonFilmTitle,FILTER_SANITIZE_STRING);     
            $handler = $this -> get('filmapi.command_handler.findFilmByTitle');
            $film = $handler -> handle($title);
            var_dump($film);
            $this -> end();                   
            return new JsonResponse(
            ['success' => 'Film Found', 'film' => $film ->toArray()],
                200
            );


        }

        private function end()
        {
            $this->get('doctrine.orm.default_entity_manager')->flush();
        }
    }