<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture

{
     private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

public function load(ObjectManager $manager)
{
    $faker = Faker\Factory::create('fr_FR');
    for($i=0;$i<5;$i++){
        $user = new User();
        $user
            ->setEmail($faker->email)
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'test'
            ))
            ->setRoles(["ROLE_USER"]);
        $manager->persist($user);
    }
    $admin = new User();
    $admin
        ->setEmail('admin@mail.fr')
        ->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin'
        ))        ->setRoles(["ROLE_ADMIN"]);
    $manager->persist($admin);

    $manager->flush();
}
}
