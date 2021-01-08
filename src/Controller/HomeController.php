<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Customers;
use App\Entity\Rqst;
use App\Entity\Tickets;
use App\Entity\User;
use App\Repository\RqstRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    function count_customers(): Response
    {


        return new Response($totalCustomers);

    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin(): Response
    {
        // 1. Obtain doctrine manager
        $em = $this->getDoctrine()->getManager();

        // 2. Setup repository of some entity
        $repoCustomers = $em->getRepository(Customers::class);
        $repoCompany = $em->getRepository(Company::class);
        $repoTickets = $em->getRepository(Tickets::class);

        // 3. Query how many rows are there in the Articles table
        $totalCustomers = $repoCustomers->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $totalCompany = $repoCompany->createQueryBuilder('b')
            ->select('count(b.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $totalTickets = $repoTickets->createQueryBuilder('c')
            // Filter by some parameter if you want
            ->where("c.status = 'ouvert'")
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
        // 4. Return a number as response

        return $this->render('home/admin.html.twig', [
            'controller_name' => 'HomeController',
            'totalCustomers' => $totalCustomers,
            'totalCompany' => $totalCompany,
            'totalTickets' => $totalTickets
        ]);
    }
    /**
     * @Route("/user/{id}", name="user")
     */
    public function user(): Response
    {
        $em = $this->getDoctrine()->getRepository(Rqst::class);

        return $this->render('home/user.html.twig', [
             'controller_name' => 'HomeController',
            'rqst' => $em->findAll()
         ]);
    }
    /**
     * @Route("/plus", name="plus")
     */
    public function plus(): Response
    {
        return $this->render('home/plus.html.twig', [
            'controller_name' => 'HomeController',
        ]);

    }
}
