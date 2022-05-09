<?php

namespace App\DataFixtures;

use App\Entity\Bookmark;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookmarksFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $bookmark = new Bookmark();
            $bookmark->setName($faker->word);
            $bookmark->setUrl('https://www.movistar.com.ec');
            $bookmark->setFavorite($faker->boolean());
            $bookmark->setCategory($this->getReference(CategoriesFixtures::REFERENCE_MOVISTAR_CATEGORY));
            $manager->persist($bookmark);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoriesFixtures::class,
        ];
    }
}
