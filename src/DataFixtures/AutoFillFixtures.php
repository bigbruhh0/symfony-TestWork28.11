<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

//Прикрутил группы
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

use App\Entity\Couriers;
use App\Entity\Regions;

class AutoFillFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $names = [
            "Иванов Иван",
            "Петров Петр",
            "Сидоров Сидор",
            "Алексеев Алексей",
            "Смирнов Сергей",
            "Кузнецов Константин",
            "Васильев Василий",
            "Морозов Михаил",
            "Новиков Николай",
            "Федоров Федор"
        ];
        $regions = [
            ['Санкт-Петербург', 5],
            ['Уфа', 7],
            ['Нижний Новгород', 4],
            ['Владимир', 3],
            ['Кострома', 6],
            ['Екатеринбург', 10],
            ['Ковров', 2],
            ['Воронеж', 5],
            ['Самара', 8],
            ['Астрахань', 12]
        ];
        foreach ($names as $name)
        {
            $courier = new Couriers();
            $courier->setName($name);
            $manager->persist($courier);
        }
        foreach ($regions as $reg)
        {
            $region = new Regions();
            $region->setName($reg[0]);
            $region->setDays($reg[1]);
            $manager->persist($region);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['auto_fill'];
    }
}
