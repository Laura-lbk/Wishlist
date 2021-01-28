<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;

class CategorieFixtures extends Fixture 
{
    public function load(ObjectManager $manager)
    {

        $categorie = new Categorie;
        $categorie->setNom('NSFW');
        $manager->persist($categorie);
        $manager->flush();

        $categorie = new Categorie;
        $categorie->setNom('Jouet');
        $manager->persist($categorie);
        $manager->flush();

        $categorie = new Categorie;
        $categorie->setNom('Peluche');
        $manager->persist($categorie);
        $manager->flush();

        $categorie = new Categorie;
        $categorie->setNom('Maquillage');
        $manager->persist($categorie);
        $manager->flush();

        $categorie = new Categorie;
        $categorie->setNom('Jeu video');
        $manager->persist($categorie);
        $manager->flush();
    }
}
