<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\AdresseFixtures;
use App\DataFixtures\CadeauFixtures;
use App\Entity\Personne;
use App\Entity\User;
use App\Entity\Adresse;
use App\Entity\Cadeau;

class PersonneFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            AdresseFixtures::class,
            CadeauFixtures::class
        );
    }

    public function load(ObjectManager $manager)
    {

        $repoUser = $manager->getRepository(User::class);
        $users = $repoUser->findAll();

        $repoAdresse = $manager->getRepository(Adresse::class);
        $adresses = $repoAdresse->findAll();

        $repoCadeau = $manager->getRepository(Cadeau::class);
        $cadeaux = $repoCadeau->findAll();

        $i=1;
        foreach($users as $user){
            if($user->getRoles() == ['ROLE_USER']){
                
                $personne = new Personne;
                $personne->setNom('Nom'.$i);
                $personne->setPrenom('Prenom'.$i);
                if($i%2 == 0){
                    $personne->setSexe('femme');
                    $personne->setBirthday(new \DateTime('2010-02-15'));
                    $personne->setAdresse($adresses[0]);
                }else{
                    $personne->setSexe('homme');
                    $personne->setBirthday(new \DateTime('1950-02-15'));
                    $personne->setAdresse($adresses[1]);
                } 
                for($i=0;$i<rand(1,2);$i++){
                    $personne->addCadeaux($cadeaux[rand(0,count($cadeaux)-1)]);
                }   
                $personne->setUser($user);
                $i++;
                $manager->persist($personne);
            }
        }
        $manager->flush();
    }
}