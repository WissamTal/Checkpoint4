<?php

namespace App\Service;


use App\Entity\Language;
use App\Entity\Repos;
use App\Form\ReposType;
use App\Repository\LanguageRepository;
use App\Repository\ReposRepository;
use App\Repository\RepoStateRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Array_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class repoService
{
    private $client;
    private $reposRepository;
    private $languageRepository;
    private $repoStateRepository;
    private $entityManager;

    public function __construct(HttpClientInterface $client, ReposRepository $reposRepository, LanguageRepository $languageRepository, RepoStateRepository $repoStateRepository, EntityManagerInterface $entityManager)
    {
        $this->client = $client;
        $this->reposRepository = $reposRepository;
        $this->languageRepository = $languageRepository;
        $this->repoStateRepository = $repoStateRepository;
        $this->entityManager = $entityManager;
    }


    public function addReposToDb()
    {
        define("USERNAME", "WissamTal");
        define("APIKEY", "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");

        $repos = $this->synchronizeGithub();

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

            $registeredRepo = $this->reposRepository->findOneBy(['githubID' => $githubId]);

            $newState = $this->repoStateRepository->findOneBy(['name' => 'NEW' ]);


            if (is_null($registeredRepo)) {
                $createdRepo = new Repos();
                $createdRepo->setName($fullName);
                $createdRepo->setDescription($description);
                $createdRepo->setDate($date);
                $createdRepo->setGithubID($githubId);
                $createdRepo->setUrl($url);
                $createdRepo->setRepoState($newState);

                $allRepos[] = $createdRepo;
            }

            if (!is_null($registeredRepo)) {
                $allRepos[] = $registeredRepo;
            }
        }

        //Loop Register Language
        $registeredlanguages = $this->languageRepository->findAll();

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
            $this->entityManager->persist($persistLanguage);
            $this->entityManager->flush();
        }

        //Loop persist repo
        foreach ($allRepos as $persistRepo) {
            $this->entityManager->persist($persistRepo);
            $this->entityManager->flush();
        }

        return new Response('Success');
    }

    public function synchronizeGithub(): array
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