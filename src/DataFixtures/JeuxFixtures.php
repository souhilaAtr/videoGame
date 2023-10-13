<?php

namespace App\DataFixtures;

use App\Entity\Jeux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JeuxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 6; $i++) {
            $jeux = new Jeux();

            $jeux->setNomJeu("Mario$i")
                ->setGenre("platform")
                ->setDescription("jeu de platforme pour les petits")
                ->setImgCouverture("https://picsum.photos/id/2$i" . "7/200/300")
                ->setNoteMoyenne(rand(10, 20))
                ->setRealisedAt(new \DateTime());
                if($i % 2 === 0 ){
                      $jeux->setType("location");
                }else{
                    $jeux->setType("vente");
                }
              

            $manager->persist($jeux);
        }

        $manager->flush();
    }
}
