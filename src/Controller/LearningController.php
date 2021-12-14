<?php

namespace App\Controller;

use App\Entity\LearningLanguage;
use App\Entity\User;
use App\Form\LearningType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LearningController extends AbstractController
{
    #[Route('/my/learnings', name: 'learnings')]
    public function index(): Response
    {
		// TODO
        return $this->render('learning/index.html.twig', [
            'controller_name' => 'LearningController',
        ]);
    }

	#[Route('/my/learnings/create', name: 'learning_create')]
	public function createLearning(#[CurrentUser]User $user, Request $request, EntityManagerInterface $entityManager): Response
	{
		$learning = new LearningLanguage();
		$learningForm = $this->createForm(LearningType::class, $learning);
		$learningForm->handleRequest($request);
		if ($learningForm->isSubmitted() && $learningForm->isValid()) {
			$learning->setUser($user);
			$entityManager->persist($learning);
			$entityManager->flush();

			return $this->redirectToRoute('dashboard');
		}

		return $this->render('learning/create.html.twig', [
			'form' => $learningForm->createView()
		]);
	}
}
