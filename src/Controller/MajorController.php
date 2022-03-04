<?php

namespace App\Controller;

use App\Entity\Major;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MajorController extends AbstractController
{
    /**
     * @Route("/major", name="list_major")
     */
    public function listMajor()
    {
        $em = $this->getDoctrine()->getRepository(Major::class);
        $majors= $em->findAll();
        return $this->render('major/index.html.twig', array('majors' => $majors));
    }

    /**
     * @Route("/major/create", name="major_create", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $major = new Major();
        $form = $this->createForm(MajorType::class, $major);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $major->setMajorName($request->request->get('major')['MajorName']);
            $entityManager->persist($major);
            $entityManager->flush();

            return $this->redirectToRoute('list_major', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('major/create.html.twig', [
            'category' => $major,
            'form' => $form,
        ]);
    }
}
