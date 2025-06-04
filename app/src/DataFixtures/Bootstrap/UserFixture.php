<?php

namespace App\DataFixtures\Bootstrap;

use App\Common\Domain\Entity\User;
use App\User\Domain\Enums\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('support@symerce.com');
        $user->setFirstname('Support');
        $user->setSurname('Symerce');
        $user->setPassword(password_hash('mdVN_8LlS@+0', PASSWORD_DEFAULT));
        $user->setRoles([UserRole::ROLE_ADMIN->value]);
        $user->setActive(true);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $manager->persist($user);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['bootstrap'];
    }
}
