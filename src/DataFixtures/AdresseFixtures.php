<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Adresse;

class AdresseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $adresse = new Adresse;
        $adresse->setRue('Rue des coquelicots');
        $adresse->setNum(12);
        $adresse->setCodePostal(80000);
        $adresse->setVille('Amiens');
        $manager->persist($adresse);

        $adresse = new Adresse;
        $adresse->setRue('Impasse des 3 Vents');
        $adresse->setNum(42);
        $adresse->setCodePostal(80000);
        $adresse->setVille('Amiens');
        $manager->persist($adresse);

        $manager->flush();
    }
}
