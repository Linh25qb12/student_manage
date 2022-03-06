<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {

        // $product = new Product();
        // $manager->persist($product);
        $adminUser = new User();
        $adminUser->setEmail("admin@gmail")->setName("admin");
        $password = $this->hasher->hashPassword($adminUser, "password123");
        $adminUser->setPassword($password)->setRoles(["ROLE_ADMIN"]);
        $manager->persist($adminUser);
        $manager->flush();
        $manager->flush();
    }
}
