<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo/create', name: 'todo_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Trenutno ulogiran korisnik
        $todo = new Todo();

        // Kreiramo formu i prosleđujemo korisnika kao opciju
        $form = $this->createForm(TodoType::class, $todo, [
            'user' => $user,  // Prosljeđujemo korisnika formi
        ]);

        $form->handleRequest($request);

        // Ako je forma poslata i validna
        if ($form->isSubmitted() && $form->isValid()) {
            // Spremamo Todo u bazu
            $todo->setUser($user);
            $entityManager->persist($todo);
            $entityManager->flush();

            // Prosljeđujemo na listu Todos
            return $this->redirectToRoute('todo_list');
        }

        // Renderujemo formu u šablonu
        return $this->render('todo/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/todo/list',name:'todo_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if(!$user){
            throw $this->createAccessDeniedException("Morate biti prijavljeni");
        }


        $todos = $entityManager->getRepository(Todo::class)->findBy(['user' => $user]);
        return $this->render('todo/list.html.twig',[
            'todos' => $todos,
        ]);
    }

    #[Route('/todo/{id}/delete', name: 'todo_delete', methods: ['DELETE'])]
    public function delete($id,TodoRepository $todoRepository,EntityManagerInterface $entityManager):JsonResponse
    {
        $todo = $todoRepository->find($id);
        if(!$todo){
            return new JsonResponse(['message' => 'Todo not found'],404);
        }
        $entityManager->remove($todo);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Todo deleted successfully']);
    }

    #[Route('/todo/{id}/toggle-finished',name:'todo_toggle_finished',methods:['POST'])]
    public function toggleFinished(int $id,TodoRepository $todoRepository,EntityManagerInterface $entityManager,Request $request):JsonResponse
    {
        $todo = $todoRepository->find($id);
        if(!$todo){
            return new JsonResponse(['succes' => false,'message' => 'Todo not found'],404);
        }

        $data = json_decode($request->getContent(),true);
        $newStatus = $data['isFinished'] ?? false;

        $todo->setIsFinished($newStatus);
        $entityManager->flush();

        return new JsonResponse([
            'success' => true,
            'newStatus' => $newStatus,
        ]);
    }
}
