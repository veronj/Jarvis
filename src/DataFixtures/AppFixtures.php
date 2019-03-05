<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
            $user->setLastname('Dupont')
                 ->setFirstname('Albert')
                 ->setCreatedAt(new \DateTime())
                 ->setUpdatedAt(new \DateTime());
            $manager->persist($user);

            $user2 = new User();
            $user2->setLastname('Martin')
                 ->setFirstname('Michel')
                 ->setCreatedAt(new \DateTime())
                 ->setUpdatedAt(new \DateTime());
            $manager->persist($user2);
        

        
        $manager->flush();
    }
}
