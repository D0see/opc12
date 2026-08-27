<?php

namespace App\DataFixtures;

use App\Entity\Month;
use App\Entity\PostalCode;
use App\Entity\Tip;
use App\Entity\User;
use App\Entity\WeatherMesurement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture {

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher
    ){}

    public function load(ObjectManager $manager): void
    {
        $months = [
            [1, 'Janvier'],
            [2, 'Février'],
            [3, 'Mars'],
            [4, 'Avril'],
            [5, 'Mai'],
            [6, 'Juin'],
            [7, 'Juillet'],
            [8, 'Août'],
            [9, 'Septembre'],
            [10, 'Octobre'],
            [11, 'Novembre'],
            [12, 'Décembre'],
        ];

        $monthMap = [];

        foreach ($months as [$num, $label]) {
            $month = (new Month())->setNum($num)->setLabel($label);
            $manager->persist($month);
            $monthMap[$num] = $month;
        }

        $postalCode = (new PostalCode())
        ->setCode("35000");
        
        $manager->persist($postalCode);

        $user = (new User())
        ->setLogin('test')
        ->setPostalCode($postalCode);

        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'test'));

        $manager->persist($user);

        $tip = (new Tip())
        ->setUser($user)
        ->setContent('test tip')
        ->addMonth($monthMap[1]);

        $tip2 = (new Tip())
        ->setUser($user)
        ->setContent('test tip 2')
        ->addMonth($monthMap[8]);

        $manager->persist($tip);
        $manager->persist($tip2);

        $weatherMesurement = (new WeatherMesurement())
        ->setPostalCode($postalCode)
        ->setTemperature(12)
        ->setMesuredAt(new \DateTimeImmutable());

        $manager->persist($weatherMesurement);

        $manager->flush();
    }

}