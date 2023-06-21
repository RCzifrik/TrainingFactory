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

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_home')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
    #[Route('/admin/trainers', name: 'admin_trainerOverzicht')]
    public function trainerOverzicht(ManagerRegistry $doctrine): Response
    {

        $trainer = $doctrine->getRepository(User::class)->findBy(['isTrainer' => true]);

        return $this->render('admin/trainerOverzicht.html.twig', [
            'trainers' => $trainer
        ]);
    }

    #[Route('/admin/trainer_details/{id}', name: 'admin_trainerDetails')]
    public function trainerDetails(int $id): Response
    {
        return $this->render('admin/trainerDetail.html.twig');
    }

    #[Route('/admin/trainingen', name: 'admin_allTrainings')]
    public function allTrainings(ManagerRegistry $doctrine): Response
    {

        $training = $doctrine->getRepository(Training::class)->findAll();

        return $this->render('admin/trainingOverzicht.html.twig', [
            'trainings' => $training
        ]);
    }

    #[Route('/admin/trainingen/{id}', name: 'admin_trainingSorted')]
    public function trainingSorted(ManagerRegistry $doctrine, int $id): Response
    {

        $lessons = $doctrine->getRepository(Lesson::class)->findBy(['training' => $id]);
        $trainings = $doctrine->getRepository(Training::class)->findBy(['id' => $id]);


        return $this->renderForm('admin/lessonOverzicht.html.twig', [
            'lessons' => $lessons,
            'trainings' => $trainings
        ]);
    }

    #[Route('/admin/training_details/{id}', name: 'admin_trainingDetails')]
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
            return $this->redirectToRoute('admin_allTrainings');
        }

        return $this->renderForm('admin/lessonDetail.html.twig', [
            'trainings' => $trainings,
            'form' => $form
        ]);
    }

    #[Route('/admin/training_insert', name: 'admin_trainingInsert')]
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
            return $this->redirectToRoute('admin_allTrainings');
        }

        return $this->renderForm('admin/lessonInsert.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('admin/update_training/{id}', name: 'admin_trainingUpdate')]
    public function trainingUpdate(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        return $this->render('instructor/lessonUpdate.html.twig');
    }

    #[Route('admin/contact', name: 'admin_contact')]
    public function contact(): Response
    {
        return $this->render('admin/contact.html.twig');
    }
}
