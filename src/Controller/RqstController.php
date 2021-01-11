<?php

namespace App\Controller;

use App\Entity\Rqst;
use App\Entity\User;
use App\Form\RqstType;
use App\Repository\RqstRepository;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
    public function new(Request $request, UserInterface $user, MailerInterface $mailer): Response
    {
        $rqst = new Rqst();
        $form = $this->createForm(RqstType::class, $rqst);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $rqst->setUser($user);
            $entityManager->persist($rqst);
            $entityManager->flush();

            $object = $rqst->getObject();
            $user_email = $rqst->getUser()->getEmail();
            $ifnew = true;
            $this->send_email($object, $user_email, $mailer, $ifnew);

            return $this->redirectToRoute('user', ['uid' => $user->getId()]);
        }

        return $this->render('rqst/new.html.twig', [
            'rqst' => $rqst,
            'form' => $form->createView()
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
    public function edit(Request $request, Rqst $rqst, UserInterface $user, MailerInterface $mailer): Response
    {
        $form = $this->createForm(RqstType::class, $rqst);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $object = $rqst->getObject();
            $user_email = $rqst->getUser()->getEmail();
            $ifnew = false;
            $this->send_email($object, $user_email, $mailer, $ifnew);

            return $this->redirectToRoute('user', ['uid' => $user->getId()]);
        }

        return $this->render('rqst/edit.html.twig', [
            'rqst' => $rqst,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rqst_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rqst $rqst, UserInterface $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rqst->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rqst);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user', ['uid' => $user->getId()]);
    }

    public function send_email($object, $user_email, $mailer, $ifnew) {
        $email = (new NotificationEmail())
            ->from('admin@mail.fr')
            ->to('boostmacom@gmail.com')
            ->subject('Nouvelle demande client')
            ->markdown(<<<EOF
        Nouvelle demande générée par $user_email, merci de la consulter la demande dont l'objet est : $object et de créer un ticket.
        EOF
            )
            ->importance(NotificationEmail::IMPORTANCE_HIGH)
        ;
        $email_edit = (new NotificationEmail())
            ->from('admin@mail.fr')
            ->to('boostmacom@gmail.com')
            ->subject('Edition de la demande client')
            ->markdown(<<<EOF
        Information: le client $user_email, vient de modifier la demande dont l'objet est devenu: $object.
        EOF
            )
            ->importance(NotificationEmail::IMPORTANCE_HIGH)
        ;

        try {
            if($ifnew){
                $mailer->send($email);
            } else {
                $mailer->send($email_edit);
            }
        } catch (TransportExceptionInterface $e) {
            var_dump($e);
        }
    }
}

