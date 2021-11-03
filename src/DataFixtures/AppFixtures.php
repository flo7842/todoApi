<?php

namespace App\DataFixtures;

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

        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setTitle('task '.$i);
            $task->setCreatedAt(new DateTime());
            $task->setStatus(mt_rand(0, 1));
            $manager->persist($task);

            for($j = 0; $j < 5; $j++){
                $user = new User();
                $user->setEmail($faker->email);
                $user->setPassword($this->encoder->encodePassword($user, 'password'));
                $user->setNbrOfTasks(mt_rand(1, 4));
                $user->setCreatedAt(new DateTime());
                $user->setNbrOfTasks(mt_rand(1, 4));
                $user->addTask($task);
                $manager->persist($user);
            }
        }

        $adminUser = new User();
        $adminUser->setEmail("florianbracq42@gmail.com");
        $adminUser->setPassword($this->encoder->encodePassword($adminUser, 'password'));
        $adminUser->setRoles(['ROLE_ADMIN']);
    
        $manager->persist($adminUser);

        $manager->flush();
    }
}
