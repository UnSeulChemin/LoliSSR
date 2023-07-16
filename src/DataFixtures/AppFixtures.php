<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Chat;
use Faker\Factory;
use Faker\Generator;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
        $this->faker = Factory::create('fr FR');
    }

    public function load(ObjectManager $manager): void
    {
        // Images
        $images = [];

        // Filler, Image Name
        $filler = 1;

        for ($i = 1; $i <= 121; $i++)
        {
            $image = new Image();
            $image->setName($filler . '.jpg');
            $image->setType('可爱');
            $image->setGender('女');

            $images[] = $image;
            $manager->persist($image);

            $filler++;
        }

        // Users
        $users = [];

        $user = new User();
        $user->setEmail('lolissr@contact.com');
        $user->setName('admin');
        $user->setPassword($this->passwordEncoder->hashPassword($user, 'azerty'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++)
        {
            $user = new User();
            $user->setEmail($this->faker->email());
            $user->setName($this->faker->name());
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'azerty'));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);

            $users[] = $user;
            $manager->persist($user);
        }

        // Chats
        $chats = [];

        for ($i = 1; $i <= 10; $i++)
        {
            $chat = new Chat();
            $chat->setName($this->faker->name());
            $chat->setUser($users[mt_rand(0, count($users) -1)]);
            $chat->setMessage($this->faker->text(50));

            $chats[] = $chat;
            $manager->persist($chat);
        }        

        // Contacts
        $contacts = [];

        for ($i = 1; $i <= 20; $i++)
        {
            $contact = new Contact();
            $contact->setEmail($this->faker->email());
            $contact->setName($this->faker->name());
            $contact->setSubject($this->faker->text(10));
            $contact->setMessage($this->faker->text(50));
            $contact->setUser($users[mt_rand(0, count($users) -1)]);

            $contacts[] = $contact;
            $manager->persist($contact);
        }

        $manager->flush();
    }
}