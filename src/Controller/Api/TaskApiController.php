<?php

namespace App\Controller\Api;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Uid\Uuid;

#[Route('/api/task', name: 'api_task_')]
#[IsGranted('ROLE_ADMIN')]
class TaskApiController extends AbstractController
{
    #[Route('/{uuid}/status', name: 'update_status', methods: ['POST'])]
    public function updateStatus(
        string $uuid,
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $task = $em->getRepository(Task::class)->find($uuid);
        
        if (!$task) {
            return $this->json(['error' => 'Zadanie nie znalezione'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $newStatus = $data['status'] ?? null;
        
        $allowedStatuses = ['Oczekujący', 'Wykonany', 'Odrzucony'];
        
        if (!in_array($newStatus, $allowedStatuses, true)) {
            return $this->json(['error' => 'Nieprawidłowy status'], 400);
        }

        $task->setStatus($newStatus);
        $em->flush();


        return $this->json([
            'success' => true,
            'newStatus' => $newStatus
        ]);
    }
}
