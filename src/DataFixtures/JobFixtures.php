<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class JobFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $job1 = new Job();
        $job1->setTitle('paysagiste');
        $manager->persist($job1);

        $job2 = new Job;
        $job2->setTitle('boulanger');
        $manager->persist($job2);

        $job3 = new Job;
        $job3->setTitle('informaticien');
        $manager->persist($job3);

        $job4 = new Job;
        $job4->setTitle('gigolo');
        $manager->persist($job4);

        $job5 = new Job;
        $job5->setTitle('senteur de  dessous de bras');
        $manager->persist($job5);

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getOrder()
    {
    return 1;
    }
}