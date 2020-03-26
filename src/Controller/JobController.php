<?php

namespace App\Controller;


use App\Entity\Job;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{

    /**
     * @Route("/job", name="job", methods={"POST"})
     */
    public function index()
    {
        return $this->render('job/index.html.twig', [
            'controller_name' => 'JobController',
        ]);
    }


    public function create()
    {
        $job = new Job;
        $job->setTitle('paysagiste');

        $job = new Job;
        $job->setTitle('boulanger');

        $job = new Job;
        $job->setTitle('informaticien');

        $job = new Job;
        $job->setTitle('gigolo');

        $job = new Job;
        $job->setTitle('senteur de  dessous de bras');


        $manager = $this->getDoctrine()->getManager();
        $manager->persist($job);
        $manager->flush;
    }

}
