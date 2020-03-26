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


}
