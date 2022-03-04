<?php

namespace App\Controller;

use App\Entity\Major;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
