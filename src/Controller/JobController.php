<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Job;

class JobController extends AbstractController
{

    #[Route('/job', name: 'app_job')]
    public function index(): Response
    {

        $entityManager = $this ->getDoctrine() ->getManager();
        $job = new job();
        $job -> setType('developpeur');
        $job->setCompany('proxym');
        $job->setDescription('genie logiciel');
        $job ->setExpiresAt(new \DateTimeImmutable());
        $job ->setEmail('feryeljaafour@gmail.com');
        $image=new Image();
        $image->setUrl('https://cdn.pixabay.com/photo/2015/10/30/03/ gold-1013618_960_720.jpg');
        $image->setAlt('job de reves');
   
        $candidature1=new Candidature();
        $candidature1->setCandidat("feryel");
        $candidature1->setContenu("formation symfony");
        $candidature1->setDatec(new \DateTime());
        $candidature2=new Candidature();
        $candidature2->setCandidat("asma");
        $candidature2->setContenu("formation JS");
        $candidature2->setDatec(new \DateTime());
        $candidature1->setJob($job);
        $candidature2->setJob($job);
        $entityManager ->persist($job);
        $entityManager ->persist($candidature1);
        $entityManager ->persist($candidature2);
        $entityManager->flush();

        return $this->render('job/index.html.twig', [
            'id' => $job ->getId(),
        ]);
    }
    
        /**
        * @Route("/job/{id}", name="job_show")
        */
        public function show($id)
        {
         $job = $this->getDoctrine()
         ->getRepository(Job::class)
         ->find($id);
         if (!$job) {
         throw $this->createNotFoundException(
         'No job found for id '.$id
         );
         }
         $em=$this->getDoctrine()->getManager();
         $candidature=$em->getRepository(Candidature::class);
         $listCandidatures=$em
         ->getRepository(Candidature::class)
         ->findBy(['Job'=>$job]);
         return $this->render('job/show.html.twig', array(
                'job' =>$job ,
                'candidature' =>$candidature,
                'listCandidatures'=>$listCandidatures));

        }
        }