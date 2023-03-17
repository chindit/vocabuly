<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\LearningLanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Security $security): Response
    {
        if ($security->getUser()) {
            return $this->forward('App\\Controller\\IndexController::dashboard');
        }

        return $this->render('index/index.html.twig');
    }

    #[Route('/my/dashboard', name: 'dashboard')]
    public function dashboard(#[CurrentUser] User $user, LearningLanguageRepository $learningLanguageRepository): Response
    {
        if ($user->getLearningLanguages()->isEmpty()) {
            return $this->forward('App\\Controller\\LearningController::createLearning');
        }

        return $this->render('index/dashboard.html.twig', [
            'stats' => $learningLanguageRepository->getStatistics($user),
        ]);
    }
}
