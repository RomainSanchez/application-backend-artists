<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\RestController;
use Symfony\Component\HttpFoundation\Request;

class ArtistController extends RestController
{
    protected $fields = [
        'name', 
        'token', 
        'albums' => [
            'title', 
            'cover',
            'token'
        ]
    ];

    /**
     * @Route("/artists", methods={"GET"})
     */
    public function getArtistsAction()
    {
        $artists = $this->getDoctrine()->getRepository("App:Artist")->findAll();

        if(count($artists) < 1) {
            return new jsonResponse('No artists', 200);
        } 

        return new JsonResponse($this->serialize($artists), 200);
    }

    /**
     * @Route("/artists/{token}", methods={"GET"})
     */
    public function getArtistByTokenAction(Request $request)
    {
        $token = $request->get('token');
        $artist = $this->getDoctrine()->getManager()->getRepository("App:Artist")->findOneBy(['token' => $token]);

        if(!$artist) {
            return new JsonResponse(sprintf('Artist with token %s does not exist', $token), 404);
        }

        return new JsonResponse($this->normalize($artist), 200);
    }
}
