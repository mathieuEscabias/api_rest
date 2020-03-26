<?php

namespace App\Controller;


use App\Entity\Job;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Query\AST\JoinAssociationPathExpression;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class JobController extends AbstractController
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
     * @Route("/jobs", name="jobs", methods={"GET"})
     */
    public function getJobs()
    {
        $jobs = $this->getDoctrine()->getRepository(Job::class)->findAll();

        $data = $this->serializer->normalize($jobs,null,['groups' => 'all_jobs']);

        $jsonContent = $this->serializer->serialize($data, 'json');
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/job/{id}", name="job", methods={"GET"})
     */
    public function getJob(int $id)
    {
        $jobs = $this->getDoctrine()->getRepository(Job::class)->find($id);

        $data = $this->serializer->normalize($jobs,null,['groups' => 'all_jobs']);

        $jsonContent = $this->serializer->serialize($data, 'json');
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/job/{id}", name="job", methods={"DELETE"})
     */
    public function deleteJob(int $id)
    {
        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);
        if ( !is_null($job)) {
            $this->getDoctrine()->getManager()->remove($job);
            $this->getDoctrine()->getManager()->flush();
            return new Response("job suprimmé");
        }

        return new Response("cela n'existe pas");
    }

    /**
     * @Route("/job", name="job_post", methods={"POST"})
     */
    public function create(Request $request) {

        $job = new Job;
        $job->setTitle($request->request->get('title'));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($job);
        $manager->flush();

        return new Response("la donnée a été crée", 201);
    }

    /**
     * @Route("/job/{job}", name="job_post", methods={"POST"})
     */
    public function update(Request $request, Job $job) {

        if ( !empty($request->request->get('title')))
        $job->setTitle($request->request->get('title'));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($job);
        $manager->flush();

        return new Response("la donnée a été crée", 201);
    }


}
