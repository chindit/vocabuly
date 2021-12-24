<?php

namespace App\Controller;

use App\Form\ExerciseParameterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciseController extends AbstractController
{
    #[Route('/my/exercise', name: 'create_exercise')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ExerciseParameterType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
        }

        return $this->render('exercise/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
