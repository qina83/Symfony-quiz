<?php


namespace App\Controller;


use App\Entity\Answer;
use App\Service\QuizEngineService;
use App\Service\QuizEngineServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;


class QuizController extends AbstractController
{
    private QuizEngineServiceInterface $quizEngine;
    private SessionInterface $session;

    public function __construct(QuizEngineServiceInterface $quizEngine, SessionInterface $session)
    {
        $this->quizEngine = $quizEngine;
        $this->session = $session;
    }

    /**
     * @Route("/", methods={"GET"})
     * @Route("/quiz", methods={"GET"})
     * @return Response
     */
    public function welcome(): Response
    {
        return $this->render('quiz/welcome_page.html.twig');
    }

    /**
     * @Route("quiz/start", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function start(Request $request): Response
    {
        $player = $request->request->get("player");
        $quiz = $this->quizEngine->createAQuiz($player);
        return $this->renderNextStep($quiz->getId(), $player);
    }


    /**
     * @Route("/quiz/next", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function answerToQuestion(Request $request): Response
    {
        $player = $request->request->get("player");
        $quizId = intval($request->request->get("quizId"));
        $answerId = intval($request->request->get("answer"));
        $questionId = intval($request->request->get("questionId"));

        $answer = new Answer($player, $questionId, $quizId, $answerId);
        $this->quizEngine->answerToQuestion($answer);
        return $this->renderNextStep($quizId, $player);

    }

    private function renderNextStep(int $quizId, string $player): Response
    {
        $nextQuestion = $this->quizEngine->getNextQuestion($quizId, $player);
        if ($nextQuestion == null) {
            $score = $this->quizEngine->getPlayerScore($quizId, $player);
            return $this->render('quiz/score_page.html.twig', ['score' => $score, 'player' => $player]);
        } else {
            return $this->render('quiz/question_page.html.twig', ['question' => $nextQuestion, 'player' => $player, 'quizId'=>$quizId]);
        }
    }
}