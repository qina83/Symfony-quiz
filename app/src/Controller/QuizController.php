<?php


namespace App\Controller;


use App\Service\QuizEngineService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class QuizController extends AbstractController
{
    private QuizEngineService $quizEngine;
    private SessionInterface $session;

    public function __construct(QuizEngineService $quizEngine, SessionInterface $session){
        $this->quizEngine = $quizEngine;
        $this->session = $session;
    }

    /**
     * @Route("/quiz", methods={"GET"})
     * @return Response
     */
    public function createQuiz(): Response
    {
        $quiz = $this->quizEngine->createAQuiz();
        $this->session->set("nextQuestion", 0); //solo per MVP, da spostare in un gestore
    }
}