<?php


namespace App\Controller;


use App\Bridge\AwsCognitoClient;
use App\Service\QuestionsServiceInterface;
use Symfony\Component\Intl\Exception\NotImplementedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{

    private AuthenticationUtils $authenticationUtils;

    /**
     * AdminController constructor.
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct( AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }


    /**
     * @Route("/admin")
     * @return Response
     */
    public function admin(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $lastUsername = $this->authenticationUtils->getLastUsername();
        return $this->render('admin/main_page.html.twig', ['last_username' => $lastUsername]);
    }

}