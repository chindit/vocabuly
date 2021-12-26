<?php

namespace App\Controller;

use App\Entity\LearningLanguage;
use App\Entity\TestExercise;
use App\Entity\User;
use App\Form\ExerciseParameterType;
use App\Form\TestExerciseType;
use App\Repository\VocableRepository;
use App\Service\VocableService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ExerciseController extends AbstractController
{
    #[Route('/my/exercise/create/{id}', name: 'create_exercise')]
    #[ParamConverter('learningLanguage', LearningLanguage::class, options: ['id' => 'id'])]
    public function index(
	    LearningLanguage $learningLanguage,
		#[CurrentUser] User $user,
		Request $request,
		VocableService $vocableService,
		VocableRepository $repository
    ): Response
    {
        $form = $this->createForm(ExerciseParameterType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			$test = $vocableService->createTest(
				$user,
				$form->get('direction')->getData(),
				(int)$form->get('count')->getData(),
				(bool)$form->get('revision')->getData(),
				$learningLanguage, $repository
			);

			if ($test !== null) {
				return $this->forward('App\\Controller\\ExerciseController::makeExercise', [
					'exercise' => $test
				]);
			}
        }

        return $this->render('exercise/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

	#[Route('/my/exercise/{id}', name: 'make_exercise')]
	public function makeExercise(TestExercise $exercise): Response
	{
		$form = $this->createForm(TestExerciseType::class, $exercise);

		return $this->render('exercise/make.html.twig', [
			'form' => $form->createView()
		]);
	}
}
