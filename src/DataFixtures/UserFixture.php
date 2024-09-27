<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    private array $usersData = [
        [
            'email' => 'test2@gmail.com',
            'username' => 'username',
            'firstName' => 'Test',
            'lastName' => 'User',
            'password' => 'test200',
            'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
            'isVerified' => true,
        ],
        [
            'email' => 'test3@gmail.com',
            'username' => 'username',
            'firstName' => 'Teste',
            'lastName' => 'Usererr',
            'password' => 'test300',
            'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
            'isVerified' => true,
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->usersData as $userData) {
            $user = new User();
            $user->setEmail($userData['email'])
                ->setFirstName($userData['firstName'])
                ->setLastName($userData['lastName'])
                // ->setPassword($this->passwordHasher->hashPassword($user, $userData['password']))
                ->setRoles($userData['roles'])//->setVerified($userData['isVerified'])
            ;

            $manager->persist($user);
        }
        $manager->flush();
    }
}