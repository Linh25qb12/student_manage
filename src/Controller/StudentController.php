<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/student/create", name="student_create", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('student_list');
        }

        return $this->renderForm('student/create.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    /**
     * @Route("student/show/{id}", name="student_show")
     */

    public function showStudentById($id)
    {
        $em = $this->getDoctrine()->getRepository(Student::class);
        $stu = $em->find($id);
        return $this->render('student/show.html.twig', array('student' => $stu));

    }

    /**
     * @Route("student/edit/{id}", name="student_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Student $student, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('student_list');
        }

        return $this->renderForm('student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    /**
     * @Route("student/delete/{id}", name="student_delete", methods={"GET", "POST"})
     */

    public function deleteStudent ($id){
        $em = $this
            ->getDoctrine()
            ->getManager();
        $stu = $em->getRepository(Student::class);
        $result = $stu->findByStudentId($id);
        if(!$result[0])
        {
            return $this->render('student/error.html.twig');
        }

        $em->remove($result[0]);
        $em->flush();
        return $this->redirectToRoute('student_list');

    }


}
