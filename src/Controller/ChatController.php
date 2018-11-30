<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Chatkit\Chatkit;


class ChatController extends AbstractController
{
    private $chatkit;
  
    public function __construct()
    {
        $this->chatkit = new Chatkit([
            'instance_locator' => getenv('CHATKIT_INSTANCE_LOCATOR'),
            'key' => getenv('CHATKIT_KEY')
        ]);
    }


    /**
     * @Route("authenticate_user", methods={"POST"})'
     */
    public function authenticate(Request $request)
    {
        $email = $request->query->get('user_id');
        $response = $this->chatkit->authenticate([ 'user_id' => $email ]);
        return $this->json($response['body']);
    }

    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("create_user", methods={"POST"})
     */
    public function create_user(Request $request) 
    {
        $name = $request->request->get('name');
        $userId = $request->request->get('user_id');
        
        try{
            $response = $this->chatkit->createUser([
                'id' => $userId,
                'name' => $name
            ]);
        } catch( \Exception $e) {
            if ( $e->getMessage() == 'User with given id already exists' ) {
                $response = [
                    'status' => 200,
                    'body' => [
                        'id' => $userId,
                        'name' => $name,
                    ]
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => $e->getMessage()
                ];
            }
        }
        
        return $this->json($response);
    }


    /**
     * @route("create_room", methods={"POST"})
     */
    public function create_room(Request $request) 
    {
        $userId = $request->request->get('user_id');
        $roomName = $request->request->get('room_name');
        
        $response = $this->chatkit->createRoom([
            'creator_id' => $userId,
            'name' => $userId,
            'user_ids' => [$userId],
            // 'private' => true,
        ]);
        
        return $this->json($response);
    }
    
    /**
     * @Route("get_rooms")
     */
    public function get_rooms() 
    {
        return $this->json(
            $this->chatkit->getRooms(["include_private" => true])
        );
    }

}