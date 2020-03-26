<?php

namespace App\DataFixtures;


use App\Entity\Job;
use App\Entity\Employee;
use App\Repository\JobRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class EmployeeFixtures extends Fixture implements OrderedFixtureInterface
{
    private  $jobRepository;

    public function __construct( JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {

            $job =  $manager->getRepository(Job::class)->find(rand(1,5));
            $employee = new Employee();
            $employee->setFirstname( $faker->firstName);
            $employee->setLastname($faker->lastName);
            $employee->setEmployement($faker->dateTime);

            $employee->setJob($job);
            $manager->persist($employee);

        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        return 2;
    }
}
