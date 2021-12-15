<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vocable;
use App\Form\VocableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class VocableController extends AbstractController
{
    #[Route('/my/vocable/add', name: 'add_vocable')]
    public function addWord(#[CurrentUser]User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
		if (!$user->getLearningLanguages()->first())
		{
			return $this->redirect('learning_create');
		}
        $vocable = new Vocable();
        $vocableForm = $this->createForm(VocableType::class, $vocable);
        $vocableForm->handleRequest($request);
        if ($vocableForm->isSubmitted() && $vocableForm->isValid()) {
            $vocable->setUser($user);
			$vocable->setLearningLanguage($user->getLearningLanguages()->first());
            $entityManager->persist($vocable);
            $entityManager->flush();

            $this->addFlash('info', 'Mot correctement ajouté');
            // Reset form
            $vocable = new Vocable();
            $vocableForm = $this->createForm(VocableType::class, $vocable);
        }

        return $this->render('index/vocable.html.twig', ['form' => $vocableForm->createView()]);
    }
}
