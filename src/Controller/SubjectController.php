<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SubjectController extends AbstractController
{
    /**
     * @Route("/subject", name="list_subject")
     */
    public function listSubject()
    {
        $em = $this->getDoctrine()->getRepository(Subject::class);
        $subjects = $em->findAll();
        return $this->render('subject/index.html.twig',
            array('subjects' => $subjects,)
        );
    }

    /**
     * @Route("/subject/create", name="subject_create", methods={"GET","POST"})
     */
    public function subjectCreate(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($subject);
            $entityManager->flush();

            return $this->redirectToRoute('list_subject');
        }

        return $this->renderForm('subject/create.html.twig', [
            'subject' => $subject,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/subject/delete/{id}", methods={"GET"}, name="delete_subject")
     */
    public function subjectDelete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $subject = $em->getRepository(Subject::class)->find($id);

        if(!$subject)
        {
            return $this->render('subject/error.html.twig');
        }

        $em->remove($subject);
        $em->flush();
        return $this->render('subject/success.html.twig');
    }

    /**
     * @Route("subject/edit/{id}", name="edit_subject", methods={"GET", "POST"})
     */
    public function subjectEdit(Request $request, EntityManagerInterface $entityManager, Subject $subject)
    {
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($subject);
            $entityManager->flush();

            return $this->redirectToRoute('list_subject');
        }

        return $this->renderForm('subject/edit.html.twig', [
            'subject' => $subject,
            'form' => $form,
        ]);
    }
}
