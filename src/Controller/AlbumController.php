<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\RestController;
use App\Utils\TimeConverter;

class AlbumController extends RestController
{
    protected $fields = [
        'token',
        'title',
        'description',
        'cover',
        'artist' => [
            'name',
            'token'
        ],
        'songs' => [
            'title',
            'length'
        ]
    ];

    /**
     * @Route("/albums/{token}", methods={"GET"})
     */
    public function getAlbumByTokenAction(Request $request)
    {
        $token = $request->get('token');
        $album = $this->getDoctrine()->getManager()->getRepository("App:Album")->findOneBy(['token' => $token]);

        if(!$album) {
            return new JsonResponse(sprintf('Album with token %s does not exist', $token), 404);
        }

        $normalizedAlbum = $this->normalize($album);
        
        foreach($normalizedAlbum['songs'] as &$song) {
            $song['length'] = Timeconverter::secondsToMinutes($song['length']);
        }

        return new JsonResponse($normalizedAlbum, 200);
    }
}
