<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HelloController extends AbstractController
{
    /**
     * @Route("/hello/{firstname}", name="hello")
     */
    public function index(string $firstname): Response
    {
       
        
        return $this->render('hello.html.twig', [
            'firstname' => $firstname
        ]);
    }
}
