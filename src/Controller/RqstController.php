<?php

namespace App\Controller;

use App\Entity\Rqst;
use App\Form\RqstType;
use App\Repository\RqstRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rqst")
 */
class RqstController extends AbstractController
{
    /**
     * @Route("/", name="rqst_index", methods={"GET"})
     */
    public function index(RqstRepository $rqstRepository): Response
    {
        return $this->render('rqst/index.html.twig', [
            'rqsts' => $rqstRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rqst_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rqst = new Rqst();
        $form = $this->createForm(RqstType::class, $rqst);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rqst);
            $entityManager->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('rqst/new.html.twig', [
            'rqst' => $rqst,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rqst_show", methods={"GET"})
     */
    public function show(Rqst $rqst): Response
    {
        return $this->render('rqst/show.html.twig', [
            'rqst' => $rqst,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rqst_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rqst $rqst): Response
    {
        $form = $this->createForm(RqstType::class, $rqst);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('rqst/edit.html.twig', [
            'rqst' => $rqst,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rqst_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rqst $rqst): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rqst->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rqst);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user');
    }
}
