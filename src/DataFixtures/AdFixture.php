<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {

    }
    public function load(ObjectManager $manager): void
    {
        $user = $this->userRepository->findOneBy(['email' => 'test2@gmail.com']);
        for ($i = 0; $i < 10; $i++)
        {
            $ad = new Ad();

            $ad
                ->setTitle(sprintf('%s %s', 'title',$i))
                ->setOwner($user);
            $manager->persist($ad);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}