<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mime\Email;
use Symfony\Config\SwiftmailerConfig;

class PasswordEncoderSubscriber implements EventSubscriberInterface{

    /** @var UserPasswordEncoderInterface */
    private $encoder;
    private $mailer;
    private $task;
    private $taskEntity;

    public function __construct(
        UserPasswordEncoderInterface $encoder, 
        MailerInterface $mailer, 
        TaskRepository $task
    )
    {
        $this->encoder = $encoder;
        $this->mailer = $mailer;
        $this->task = $task;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE],
            KernelEvents::VIEW => ['sendMail', EventPriorities::POST_VALIDATE],
            //KernelEvents::VIEW => ['sendEmailTask', EventPriorities::POST_WRITE],
        ];
    }

    public function encodePassword(ViewEvent $event){
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if($result instanceof User && $method === "POST"){
            
            $hash = $this->encoder->encodePassword($result, $result->getPassword());
            $result->setPassword($hash);
        }
    }

    // public function sendEmail(ViewEvent $event)
    // {
        
    //     $result = $event->getControllerResult();
    //     $method = $event->getRequest()->getMethod();
        
    //     if($result instanceof User && $method === "POST"){
    //         $email = 
    //             (new Email())
    //             // email address as a simple string
    //             ->from('florian_bracq@hotmail.fr')
    //             ->to('florian_bracq@hotmail.fr')
    //             ->subject('Time for Symfony Mailer!')
    //             ->text('Sending emails is fun again!');
                
            
            
                
    //             $this->mailer->send($email);
                
    //             $response = new Response(
    //                 'Le mail a bien été envoyé',
    //                 Response::HTTP_OK,
    //                 ['content-type' => 'application/json']
    //             );
    //             return $response;
    //     }
    // }

    // public function sendEmailTask(ViewEvent $event)
    // {
    //     //die($taskRepo->findItemsCreatedBetweenTwoDates());
    //     $result = $event->getControllerResult();
    //     $method = $event->getRequest()->getMethod();

    //     //$toto = $this->task->findItemsCreatedBetweenTwoDates();
       
    //     $allTasks = $this->task->findAllTrueStatus();
    //     if($result instanceof Task && $method === "POST"){
    //         //die('toto');
    //         if(sizeof($allTasks) == 0){
    //             $email = 
    //             (new Email())
    //             // email address as a simple string
    //             ->from('florian_bracq@hotmail.fr')
    //             ->to('florian_bracq@hotmail.fr')
    //             ->subject('Time for Symfony Mailer!')
    //             ->text('Sending emails is fun again!');        
                            
    //             $this->mailer->send($email);
    //         }
    //     }
    // }


    public function sendMail(ViewEvent $event): void
    {
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $allTasks = $this->task->findAllTrueStatus();
        if($result instanceof Task && $method === "PUT"){
            foreach($allTasks[0] as $key => $value){
                var_dump($value);
                if($value == 0){
                    var_dump($value);
                    var_dump('$value');
                    $email = 
                    (new Email())
                    // email address as a simple string
                    ->from('florian_bracq@hotmail.fr')
                    ->to('florian_bracq@hotmail.fr')
                    ->subject('Time for Symfony Mailer!')
                    ->text('Sending emails is fun again!');        
                    $this->mailer->send($email);
                }
        
            }
        }
    }

}