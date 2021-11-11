<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HelloController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function index(TaskRepository $taskRepo): Response
    {
       //$allTasks = $this->getDoctrine()->getRepository(Task::class)->findAll();
        
        $allTasks = $taskRepo->findAllTrueStatus();

        //var_dump(count($allTasks));
        $toto = $allTasks;
        foreach ($toto[0] as $key => $value) {
            //var_dump($key);
            //dd($value);
            
            if($value == 6){
                 die('toto');
            }
        }

        // foreach($allTasks as $taskss){
        //     if($taskss->getStatus() !== true){
        //         continue;
        //     }else{
        //         dump($taskss->getStatus());
        //     }
        // }
        return $this->render('hello.html.twig', [
            
        ]);
    }
}
