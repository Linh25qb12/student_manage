<?php

namespace App\Controller;

use App\Entity\Score;
use App\Form\ScoreType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\BadMessageException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ScoreController extends AbstractController
{
    /**
     * @Route("/score", name="score")
     */
    public function listScore()
    {
        $em = $this->getDoctrine()->getRepository(Score::class);
        $scores = $em->findAll();
        return $this->render('score/index.html.twig', array(
            'scores' => $scores,
        ));
    }
    /**
     * @Route("/score/create", name="score_create", methods={"GET","POST"})
     */
    public function scoreCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sco = new Score();
        $form = $this->createForm(ScoreType::class, $sco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sco->setStudent($request->request->get('score')['student']);
            $sco->setSubject($request->request->get('score')['subject']);
            $sco->setScore($request->request->get('score')['score']);
            $entityManager->persist($sco);
            $entityManager->flush();

            return $this->redirectToRoute('score');
        }

        return $this->renderForm('score/create.html.twig', [
            'category' => $sco,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/score/find/{id}", name="score_find_by_StudentID")
     */
    public function findByStudentID($id)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $sco = $em->getRepository(Score::class);
        $result = $sco->findByStudentID($id);

        return $this->render('score/index.html.twig', array(
            'scores' => $result
        ));
    }
    /**
     * @Route("/score/delete/{student}/{subject}", methods={"GET"}, name="score_delete_by_id")
     */
    public function deleteByStudentID($student, $subject)
    {

        $em = $this
            ->getDoctrine()
            ->getManager();
        $sco = $em->getRepository(Score::class);
        $result = $sco->findScoreByStudentIdAndSubjectId($student, $subject);
        if(!$result)
        {
            return $this->render('score/error.html.twig');
        }

        $em->remove($result[0]);
        $em->flush();
        return $this->render('score/success.html.twig');
    }
    /**
     * @Route("/score/edit/{student}", name="score_edit", methods={"GET", "POST"})
     */
    public function scoreEdit(Request $request, Score $score, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScoreType::class, $score);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('score', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('score/edit.html.twig', [
            'score' => $score,
            'form' => $form,
        ]);
    }
}
