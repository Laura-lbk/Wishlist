<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $user = new User;
        $user->setUsername('Papa_Nowel');
        $hash = $this->passwordEncoder->encodePassword($user, 'noel');
        $user->setPassword($hash);
        $user->setRoles(array('ROLE_ADMIN'));
        $manager->persist($user);
        $manager->flush();

        //création du Secrétaire
        $user = new User;
        $user->setUsername('Secretairiat');
        $hash = $this->passwordEncoder->encodePassword($user, 'secretaire');
        $user->setPassword($hash);
        $user->setRoles(array('ROLE_SECRETARIAT'));
        $manager->persist($user);
        $manager->flush();

        //création du Gestionnaire de Stock
        $user = new User;
        $user->setUsername('Gestionnaire_de_Stock');
        $hash = $this->passwordEncoder->encodePassword($user, 'stock');
        $user->setPassword($hash);
        $user->setRoles(array('ROLE_STOCK'));
        $manager->persist($user);
        $manager->flush();

        //création d'Utilisateurs Lambda
        for ($i = 0; $i < 10; $i++) {
            $user = new User;
            $user->setUsername('User'.$i);
            $hash = $this->passwordEncoder->encodePassword($user, 'userpassword');
            $user->setPassword($hash);
            $user->setRoles(array('ROLE_USER'));
            $manager->persist($user);
        }
        $manager->flush();
    }
}