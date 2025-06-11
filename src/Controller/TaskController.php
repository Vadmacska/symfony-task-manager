<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'task_index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $task = new Task();
        $task->setUser($this->getUser());

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task_index');
        }
        if($form->isSubmitted() && !$form->isValid())
        {
            dump($form->getErrors(true, false));
            dd(); // zatrzymuje wykonanie i pokazuje błędy walidacji
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/show/{id}', name: 'task_show', methods: ['GET'], requirements: ['id' => '[0-9a-fA-F\-]{36}'])]
    public function show(Task $task): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/swimlane', name: 'task_swimlane', methods: ['GET'])]
    public function swimlane(TaskRepository $taskRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $userTasks = $taskRepository->findBy(['user' => $this->getUser()]);

        return $this->render('task/swimlane.html.twig', [
            'tasks' => $userTasks,
        ]);
    }
}
