<?php

namespace App\Controller;

use App\Entity\LearningLanguage;
use App\Entity\User;
use App\Entity\Vocable;
use App\Form\VocableType;
use App\Repository\VocableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class VocableController extends AbstractController
{
    #[Route('/my/vocable/{learningLanguage}/add', name: 'add_vocable')]
    public function addWord(
        #[CurrentUser] User $user,
        #[MapEntity(mapping: ['learningLanguage' => 'id'])] LearningLanguage $learningLanguage,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        if (!$user->getLearningLanguages()->first()) {
            return $this->redirect('learning_create');
        }

        $vocable = new Vocable();
        $vocableForm = $this->createForm(VocableType::class, $vocable);
        $vocableForm->handleRequest($request);

        if ($vocableForm->isSubmitted() && $vocableForm->isValid()) {
            $vocable->setUser($user);
            $vocable->setLearningLanguage($learningLanguage);
            $entityManager->persist($vocable);
            $entityManager->flush();

            $this->addFlash('info', 'Mot correctement ajouté');
            // Reset form
            $vocable = new Vocable();
            $vocableForm = $this->createForm(VocableType::class, $vocable);
        }

        return $this->render('index/vocable.html.twig', ['form' => $vocableForm->createView()]);
    }

    #[Route('/my/vocable/list/{page}', name: 'list_vocables', defaults: ['page' => 1])]
    public function listVocables(#[CurrentUser] User $user, VocableRepository $vocableRepository, int $page = 1): Response
    {
		$vocables = $vocableRepository->getPage($user, $page);
		$total = ceil($vocableRepository->count(['user' => $user])/25);

		return $this->render('index/listVocables.html.twig',
		[
			'vocables' => $vocables,
			'pages' => $total,
			'page' => $page
		]);
    }
}
