<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Training;
use App\Entity\User;
use App\Form\DeleteType;
use App\Form\LessonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstructorController extends AbstractController
{
    #[Route('/instructor', name: 'instructor_home')]
    public function index(): Response
    {
        return $this->render('instructor/index.html.twig');
    }

    #[Route('/instructor/trainers', name: 'instructor_trainerOverzicht')]
    public function trainerOverzicht(ManagerRegistry $doctrine): Response
    {

        $trainer = $doctrine->getRepository(User::class)->findBy(['isTrainer' => true]);

        return $this->render('instructor/trainerOverzicht.html.twig', [
            'trainers' => $trainer
        ]);
    }

    #[Route('/instructor/trainer_details/{id}', name: 'instructor_trainerDetails')]
    public function trainerDetails(int $id): Response
    {
        return $this->render('instructor/trainerDetail.html.twig');
    }

    #[Route('/instructor/trainingen', name: 'instructor_allTrainings')]
    public function allTrainings(ManagerRegistry $doctrine): Response
    {

        $training = $doctrine->getRepository(Training::class)->findAll();

        return $this->render('instructor/trainingOverzicht.html.twig', [
           'trainings' => $training
        ]);
    }

    #[Route('/instructor/trainingen/{id}', name: 'instructor_trainingSorted')]
    public function trainingSorted(ManagerRegistry $doctrine, int $id): Response
    {

        $lessons = $doctrine->getRepository(Lesson::class)->findBy(['training' => $id]);
        $trainings = $doctrine->getRepository(Training::class)->findBy(['id' => $id]);


       return $this->renderForm('instructor/lessonOverzicht.html.twig', [
           'lessons' => $lessons,
           'trainings' => $trainings
       ]);
    }

    #[Route('/instructor/training_details/{id}', name: 'instructor_trainingDetails')]
    public function trainingDetails(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $trainings = $doctrine->getRepository(Lesson::class)->findBy(['id' => $id]);

        $entitymanager = $doctrine->getManager();
        $lesson = $doctrine->getRepository(Lesson::class)->find($id);
        $form = $this->createForm(DeleteType::class, $lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager->remove($lesson);
            $entitymanager->flush();
            return $this->redirectToRoute('instructor_allTrainings');
        }

        return $this->renderForm('instructor/lessonDetail.html.twig', [
            'trainings' => $trainings,
            'form' => $form
        ]);
    }

    #[Route('/instructor/training_insert', name: 'instructor_trainingInsert')]
    public function trainingInsert(ManagerRegistry $doctrine, Request $request): Response
    {
        $entitymanager = $doctrine->getManager();
        $lesson = new Lesson();

        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lesson = $form->getData();
            $entitymanager->persist($lesson);
            $entitymanager->flush();
            return $this->redirectToRoute('instructor_allTrainings');
        }

        return $this->renderForm('instructor/lessonInsert.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('instructor/update_training/{id}', name: 'instructor_trainingUpdate')]
    public function trainingUpdate(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        return $this->render('instructor/lessonUpdate.html.twig');
    }

    #[Route('instructor/contact', name: 'instructor_contact')]
    public function contact(): Response
    {
        return $this->render('instructor/contact.html.twig');
    }
}
