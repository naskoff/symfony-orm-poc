<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\PostComment;
use App\Entity\PostTranslation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('bg_BG');
        $fakerEn = Factory::create('en_US');
        $fakerEs = Factory::create('es_ES');

        for ($userCount = 0; $userCount < 5; $userCount++) {

            $user = (new User())
                ->setUsername($faker->unique()->userName())
                ->setEmail($faker->unique()->email());
            $manager->persist($user);

            for ($postCount = 0; $postCount < 25; $postCount++) {

                $post = (new Post())
                    ->setUser($user)
                    ->setPublishAt($faker->dateTime());
                $manager->persist($post);

                $translation = (new PostTranslation())
                    ->setPost($post)
                    ->setLocale('bg_BG')
                    ->setTitle($faker->text(160))
                    ->setContent($faker->paragraph());
                $manager->persist($translation);

                $translation = (new PostTranslation())
                    ->setPost($post)
                    ->setLocale('en_US')
                    ->setTitle($fakerEn->text(160))
                    ->setContent($fakerEn->paragraph());
                $manager->persist($translation);

                $translation = (new PostTranslation())
                    ->setPost($post)
                    ->setLocale('es_ES')
                    ->setTitle($fakerEs->text(160))
                    ->setContent($fakerEs->paragraph());
                $manager->persist($translation);

                for ($commentCount = 0; $commentCount < 15; $commentCount++) {

                    $comment = (new PostComment())
                        ->setUser($user)
                        ->setPost($post)
                        ->setComment($faker->text(255))
                        ->setPublishAt($faker->dateTime());
                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
