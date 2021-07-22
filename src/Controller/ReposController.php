<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Repos;
use App\Form\ReposType;
use App\Repository\LanguageRepository;
use App\Repository\ReposRepository;
use App\Repository\RepoStateRepository;
use App\Service\repoService;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route("/repos", name="repos_")
 */
class ReposController extends AbstractController
{

    /**
     * @Route("/", name="index")
     * @IsGranted("ROLE_USER")
     */
    public function index(ReposRepository $reposRepository): Response
    {
        $repos = $reposRepository->findAll();

        return $this->render(
            'repos/index.html.twig',
            [
                'repos' => $repos,

            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function update(Request $request, Repos $repo): Response
    {
        $form = $this->createForm(
            ReposType::class,
            $repo
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('repos_index');
        }

        return $this->render(
            'repos/edit.html.twig',
            [
                'repo' => $repo,
                'form' => $form->createView(),
            ]
        );
    }


    /**
     * @Route("/api", name="api")
     */

    public function callRepoService(repoService $repoService) : Response
    {
        return $repoService ->addReposToDb();

    }
}
