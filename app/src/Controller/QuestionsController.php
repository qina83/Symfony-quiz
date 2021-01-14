<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Exception\NotImplementedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class QuestionsController
{
    /**
     * @Route("/questions", methods={"GET"})
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function getQuestions(AuthenticationUtils $authenticationUtils): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        throw new NotImplementedException("Page not implemented yet");
    }

    /**
     * @Route("/questions", methods={"POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function addQuestion(AuthenticationUtils $authenticationUtils): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        throw new NotImplementedException("Page not implemented yet");
    }

    /**
     * @Route("/question/{id}", methods={"PUT"})
     * @param AuthenticationUtils $authenticationUtils
     * @param int $id
     * @return Response
     */
    public function updateQuestion(AuthenticationUtils $authenticationUtils, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        throw new NotImplementedException("Page not implemented yet");
    }

    /**
     * @Route("/question/{id}", methods={"DELETE"})
     * @param AuthenticationUtils $authenticationUtils
     * @param int $id
     * @return Response
     */
    public function deleteQuestion(AuthenticationUtils $authenticationUtils, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        throw new NotImplementedException("Page not implemented yet");
    }
}