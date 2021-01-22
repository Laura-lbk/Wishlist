<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Personne;
use App\Entity\User;

class PersonneFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

            $personne = new Personne;
            $personne->setNom('Javel');
            $personne->setPrenom('Aude');
            $personne->setSexe('femme');
            $personne->setBirthday(new \DateTime('1950-02-15'));
            $personne->setAdresse(null);
            $personne->setUser($this->getReference(User::class));
            
            $manager->persist($personne);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}