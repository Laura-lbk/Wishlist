<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\CategorieFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Cadeau;
use App\Entity\Categorie;

class CadeauFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            CategorieFixtures::class,
        );
    }

    public function load(ObjectManager $manager)
    {
        $repo = $manager->getRepository(Categorie::class);
        $categories = $repo->findAll();

        for($i=0; $i<20; $i++){
            $cadeau = new Cadeau;
            $cadeau->setNom('Cadeau'.$i);
            if($i%5==0){
                $cadeau->setAge(18);
                $cadeau->setCategorie($categories[0]);
            }else{
                $cadeau->setAge(0);
                $cadeau->setCategorie($categories[rand(1,count($categories)-1)]);
            }
            $cadeau->setPrix(rand(1,200));
            $manager->persist($cadeau);
            $manager->flush();
        }
    }
}
