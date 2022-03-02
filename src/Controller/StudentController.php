<?php

namespace App\Controller;

use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="student_list")
     */
    public function showAllStudent()
    {
        $em = $this->getDoctrine()->getRepository(Student::class);
        $students= $em->findAll();
        return $this->render('student/index.html.twig', array('students' => $students));
    }
}
