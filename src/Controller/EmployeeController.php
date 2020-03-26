<?php

namespace App\Controller;

use App\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employee", name="employee")
     */
    public function index()
    {
        return $this->render('employee/index.html.twig', [
            'controller_name' => 'EmployeeController',
        ]);
    }
}
