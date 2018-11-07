<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class RestController extends AbstractController
{
    protected $fields = [];

    protected function normalize($data): array {
        $serializer = $this->get('serializer');

        $data = $serializer->normalize($data, null, array('attributes' => $this->fields));
        
        return $data;
    }
}