<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Customers;
use App\Entity\Rqst;
use App\Entity\Tickets;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $user_array = array();

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
            $manager->flush();
            array_push($user_array, $user->getId());
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


        $company_array = array();

        for($i=0;$i<3;$i++){
            $company = new Company();
            $company
                ->setName($faker->company)
                ->setSiret($faker->numberBetween(123456789, 234567654))
                ->setAddress($faker->streetAddress)
                ->setCity($faker->city)
                ->setZipcode($faker->numberBetween(57000, 57999));
            $manager->persist($company);
            $manager->flush();

            array_push($company_array, $company->getId());
        }

        $customer_array = array();

        for($i=0;$i<10;$i++){
            $customer = new Customers();
            $array_id = array_rand($company_array, 1);
            $customer
                ->setName($faker->lastName)
                ->setFirstname($faker->firstName)
                ->setEmail($faker->email)
                ->setAddress($faker->streetAddress)
                ->setCity($faker->city)
                ->setZipcode($faker->numberBetween(57000, 57999))
                ->setCompany($manager->getRepository(Company::class)->find($company_array[$array_id]));
            $manager->persist($customer);
            $manager->flush();

            array_push($customer_array, $customer->getId());
        }

        $rqst_status = array("Nouvelle", "En cours", "Traitée");
        $rqst_array = array();

        for($i=0;$i<7;$i++){
            $rqst = new Rqst();
            $user_id = array_rand($user_array, 1);
            $rqst_status_id = array_rand($rqst_status, 1);
            $rqst
                ->setObject($faker->sentence($nbWords=3, $variableNbWords=true))
                ->setContent($faker->paragraph($nbSentences=8, $variableNbSentences=true))
                ->setUser($manager->getRepository(User::class)->find($user_array[$user_id]))
                ->setStatus($rqst_status[$rqst_status_id]);
            $manager->persist($rqst);
            $manager->flush();

            array_push($rqst_array, $rqst->getId());
        }

        for($i=0;$i<5;$i++) {
            $tickets = new Tickets();
            if($i<3){
                $rqst_id = array_rand($rqst_array, 1);
                $tickets
                    ->setRqst($manager->getRepository(Rqst::class)->find($rqst_array[$rqst_id]))
                    ->setObject($tickets->getRqst()->getObject())
                    ->setContent($tickets->getRqst()->getContent())
                    ->setStatus('ouvert');
            }
            else{
                $tickets
                    ->setObject($faker->sentence($nbWords=3, $variableNbWords=true))
                    ->setContent($faker->paragraph($nbSentences=8, $variableNbSentences=true))
                    ->setStatus('fermé');
            }
            $manager->persist($tickets);
        }


            $manager->flush();

    }
}
