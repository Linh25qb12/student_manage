<?php

namespace App\Controller;

use App\Entity\Major;
use App\Form\MajorType;
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
            $major->setName($request->request->get('major')['Name']);
            $entityManager->persist($major);
            $entityManager->flush();

            return $this->redirectToRoute('list_major', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('major/create.html.twig', [
            'category' => $major,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/major/delete/{id}", methods={"GET"}, name="delete_major")
     */
    public function majorDelete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $major = $em->getRepository(Major::class)->find($id);

        if(!$major)
        {
            return $this->render('major/error.html.twig');
        }

        $em->remove($major);
        $em->flush();
        return $this->render('major/success.html.twig');
    }
}
