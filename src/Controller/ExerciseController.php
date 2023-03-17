<?php

namespace App\Controller;

use App\Entity\LearningLanguage;
use App\Entity\TestExercise;
use App\Entity\User;
use App\Enum\Direction;
use App\Form\ExerciseParameterType;
use App\Form\TestExerciseType;
use App\Repository\VocableRepository;
use App\Service\VocableService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ExerciseController extends AbstractController
{
    #[Route('/my/exercise/create/{id}', name: 'create_exercise')]
    public function index(
        #[MapEntity(mapping: ['learningLanguage'])] LearningLanguage $learningLanguage,
        #[CurrentUser] User $user,
        Request $request,
        VocableService $vocableService,
        VocableRepository $repository
    ): Response {
        $form = $this->createForm(ExerciseParameterType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $test = $vocableService->createTest(
                $user,
                Direction::from(strval($form->get('direction')->getData())),
                intval($form->get('count')->getData()),
                (bool)$form->get('revision')->getData(),
                $learningLanguage, $repository
            );

            if (null !== $test) {
                return $this->redirect($this->generateUrl('make_exercise', ['id' => $test->getId()]));
            }
        }

        return $this->render('exercise/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/my/exercise/{id}', name: 'make_exercise')]
    public function makeExercise(
        #[MapEntity]TestExercise $exercise,
        Request $request,
        VocableService $vocableService
    ): Response
    {
        $form = $this->createForm(TestExerciseType::class, $exercise);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vocableService->checkExercise($exercise);

            return $this->render('exercise/result.html.twig', [
                'exercise' => $exercise,
            ]);
        }

        return $this->render('exercise/make.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
