<?php

namespace App\Controller;

use App\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
