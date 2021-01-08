<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Customers;
use App\Entity\Rqst;
use App\Entity\Tickets;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

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
            $cstm_id = array_rand($customer_array, 1);
            $rqst_status_id = array_rand($rqst_status, 1);
            $rqst
                ->setObject($faker->sentence($nbWords=3, $variableNbWords=true))
                ->setContent($faker->paragraph($nbSentences=8, $variableNbSentences=true))
                ->setCustomer($manager->getRepository(Customers::class)->find($customer_array[$cstm_id]))
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
