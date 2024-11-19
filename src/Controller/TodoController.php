<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo/create', name: 'todo_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); // Trenutni ulogovani korisnik
        $todo = new Todo();

        // Kreiramo formu i prosleđujemo korisnika kao opciju
        $form = $this->createForm(TodoType::class, $todo, [
            'user' => $user,  // Prosleđujemo korisnika formi
        ]);

        $form->handleRequest($request);

        // Ako je forma poslata i validna
        if ($form->isSubmitted() && $form->isValid()) {
            // Spremamo Todo u bazu
            $todo->setUser($user);  // Postavljamo korisnika za Todo entitet
            $entityManager->persist($todo);
            $entityManager->flush();

            // Redirektujemo na listu Todos
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
}
