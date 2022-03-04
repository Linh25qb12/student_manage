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
            $subject->setName($request->request->get('subject')['Name']);
            $entityManager->persist($subject);
            $entityManager->flush();

            return $this->redirectToRoute('list_subject');
        }

        return $this->renderForm('subject/create.html.twig', [
            'category' => $subject,
            'form' => $form,
        ]);
    }
}
