<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Task;
use App\Entity\User;
use Faker\Factory;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        
        

        $faker = Factory::create('fr-FR');

        for($j = 0; $j < 3; $j++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->encoder->encodePassword($user, 'password'));
            $user->setCreatedAt(new DateTime());
            
            
            for ($i = 0; $i < mt_rand(0, 5); $i++) {
                $task = new Task();
                $task->setTitle('task '.$i);
                $task->setCreatedAt(new DateTime());
                $task->setStatus(mt_rand(0, 1));
                $task->setUserTask($user);
                $manager->persist($task);
    
            }
            
        }

        $adminUser = new Admin();
        $adminUser->setEmail("florianbracq42@gmail.com");
        $adminUser->setPassword($this->encoder->encodePassword($user, 'password'));
    
        $manager->persist($adminUser);

        $manager->flush();
    }
}
