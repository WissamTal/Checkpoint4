<?php

namespace App\DataFixtures;

use App\Entity\RepoState;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RepoStateFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $repoState = new RepoState();
        $repoState->setName('New');

        $manager->persist($repoState);

        $manager->flush();
    }
}
