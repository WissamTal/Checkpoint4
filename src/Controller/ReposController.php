<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Repos;
use App\Repository\LanguageRepository;
use App\Repository\ReposRepository;
use App\Service\CallApiService;
use DateTime;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route("/repos", name="repos_")
 */
class ReposController extends AbstractController
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(ReposRepository $reposRepository): Response
    {

        return $this->render(
            'repos/index.html.twig',
            [
                'repos' => $reposRepository->findAll()
            ]
        );
    }

    /**
     * @Route("/test", name="")
     */
    public function addReposToDb(ReposRepository $reposRepository, LanguageRepository $languageRepository)
    {
        define("USERNAME", "WissamTal");
        define("APIKEY", "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");

        $repos = $this->fetchGitHubPhpRepos();

        $items = $repos['items'];
        $allRepos = [];

        //Boucle repo
        foreach ($items as $item) {
            $githubId = $item['id'];
            $fullName = $item['full_name'];
            $description = '';
            if (!is_null($item['description'])) {
                $description = $item['description'];
            }
            $date = $item['created_at'];
            $language = $item['language'];
            $url = $item['url'];

            $registeredRepo = $reposRepository->findOneBy(['githubID' => $githubId]);

            if (is_null($registeredRepo)) {
                $createdRepo = new Repos();
                $createdRepo->setName($fullName);
                $createdRepo->setDescription($description);
                $createdRepo->setDate($date);
                $createdRepo->setGithubID($githubId);
                $createdRepo->setUrl($url);

                $allRepos[] = $createdRepo;
            }

            if (!is_null($registeredRepo)) {
                $registeredRepo->setName($fullName);
                $registeredRepo->setDescription($description);
                $registeredRepo->setDate($date);
                $registeredRepo->setUrl($url);

                $allRepos[] = $registeredRepo;
            }
        }

        //Loop Register Language
        $registeredlanguages = $languageRepository->findAll();

        $languagesByName = [];
        foreach ($registeredlanguages as $registeredLanguage) {
            $registeredLanguageName = $registeredLanguage->getLanguageName();
            $languagesByName[$registeredLanguageName] = $registeredLanguage;
        }

        //Loop language
        foreach ($allRepos as $repo) {
            $repoLanguages = $this->client->request(
                'GET',
                $repo->getUrl()."/languages",
                [
                    'auth_basic' => [USERNAME, APIKEY],
                ]
            );

            $repoLanguages = $repoLanguages->toArray();

            foreach ($repoLanguages as $language => $value) {
                if (!array_key_exists($language, $languagesByName)) {
                    $languageEntity = new Language();
                    $languageEntity->setLanguageName($language);

                    $languagesByName[$language] = $languageEntity;
                }
                $repo->addLanguage($languagesByName[$language]);
            }
        }

        //Loop persist language
        foreach ($languagesByName as $persistLanguage) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($persistLanguage);
            $entityManager->flush();
        }

        //Loop persist repo
        foreach ($allRepos as $persistRepo) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($persistRepo);
            $entityManager->flush();
        }
    }

    public function fetchGitHubPhpRepos(): array
    {
        $date = new DateTime();
        $dateAsString = $date->format('Y-m-d');
        $response = $this->client->request(
            'GET',
            'https://api.github.com/search/repositories?q=language:PHP+created:'.$dateAsString,
            [
                'auth_basic' => [USERNAME, APIKEY],
            ]
        );

        return $response->toArray();
    }

}
