<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Job;
use DateTime;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use DateTimeInterface;

class EmployeeController extends AbstractController
{

    public $serializer;

    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer($classMetadataFactory)];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/employees", name="employees", methods={"GET"})
     */
    public function getEmployees()
    {
        $jobs = $this->getDoctrine()->getRepository(Employee::class)->findAll();

        $data = $this->serializer->normalize($jobs,null,['groups' => 'all_employees']);

        $jsonContent = $this->serializer->serialize($data, 'json');
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/employee/{id}", name="employee_id", methods={"GET"})
     */
    public function getEmployee(int $id)
    {
        $jobs = $this->getDoctrine()->getRepository(Employee::class)->find($id);

        $data = $this->serializer->normalize($jobs,null,['groups' => 'all_employees']);

        $jsonContent = $this->serializer->serialize($data, 'json');
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/employee/{id}", name="employee_delete", methods={"DELETE"})
     */
    public function deleteEmployee(int $id)
    {
        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($id);
        if ( !is_null($employee)) {
            $this->getDoctrine()->getManager()->remove($employee);
            $this->getDoctrine()->getManager()->flush();
            return new Response("employée suprimmé");
        }

        return new Response("cela n'existe pas");
    }

    /**
     * @Route("/employee", name="employee_post", methods={"POST"})
     */
    public function create(Request $request) {

        $employee = new Employee();
        $employee->setFirstname($request->request->get('firstname'));
        $employee->setLastname($request->request->get('lastname'));
        $employee->setEmployement(DateTime::createFromFormat ( "Y-m-d" ,$request->request->get('employement')));

        $job = $this->getDoctrine()->getRepository(Job::class)->find( $request->request->get('job_id'));

        $employee->setJob($job);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($employee);
        $manager->flush();

        return new Response("la donnée a été crée", 201);
    }

    /**
     * @Route("/employee/{employee}", name="employee_update", methods={"POST"})
     */
    public function update(Request $request, Employee $employee) {

        $employee->setFirstname($request->request->get('firstname'));
        $employee->setLastname($request->request->get('lastname'));
        $employee->setEmployement(DateTime::createFromFormat ( "Y-m-d" ,$request->request->get('employement')));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($employee);
        $manager->flush();

        return new Response("la donnée a été modifié", 201);
    }

}
