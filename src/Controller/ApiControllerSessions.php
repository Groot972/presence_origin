<?php

namespace App\Controller;


use App\Entity\Abscences;
use App\Entity\Classes;
use App\Entity\Cours;
use App\Entity\Sessions;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ApiControllerSessions extends AbstractController
{
    /**
     * @Route("/api/addsession")
     *
     */
    public function addSession(Request $request, EntityManagerInterface $entityManager)
    {

        //On récupère les données envoyées par l'utilisateur
        $data = json_decode($request->getContent(), true);
        $jour = $data['session']['jour'];
        $heure = $data['session']['heure'];
        $classe = $data['session']['classe'];
        $matiere = $data['session']['matiere'];

        if (!empty($jour) && !empty($heure) && !empty($classe) && !empty($matiere)){
            $classeD = $entityManager->getRepository(Classes::class)->find($classe);
            $matiereD = $entityManager->getRepository(Cours::class)->find($matiere);
            $session = new Sessions();
            $session->setJour($jour);
            $session->setHeure($heure);
            $session->setClasse($classeD);
            $session->setCours($matiereD);
            $session->setAppel('non');
            $entityManager->persist($session);
            $entityManager->flush();

            $message= 'La session à été créée';
            $etat= 'success';
            $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
            return $response;
        }
        else {
            $message = "Un champ est vide est vide ! L'ajout ne peut pas être fait";
            $etat = 'error';
            $response = new JsonResponse(['message' => $message,'etat' => $etat ]);
            return $response;
        }


    }

    /**
     * @Route("/api/getcours")
     *
     */
    public function getCours(EntityManagerInterface $entityManager)
    {
        $cours = $entityManager->getRepository(Cours::class)->findAll();
        $data = array();
        foreach ($cours as $key=> $value){
            $data[$key]['libelle'] = $value->getLibelle();
            $data[$key]['id'] = $value->getId();
        }

        $response = new JsonResponse($data);
        return $response;
    }


    /**
     * @Route("/api/getsession/cours/{id}")
     */
    public function getSessionCours($id, EntityManagerInterface $entityManager){

        $listeSession = $entityManager->getRepository(Sessions::class)->findBy(array('cours' => $id));

        $data = array();
        foreach ($listeSession as $key=> $value){
            $data[$key]['jour'] = $value->getJour();
            $data[$key]['heure'] = $value->getHeure();
            $data[$key]['id'] = $value->getId();
            $data[$key]['cours'] = $value->getCours()->getLibelle();
            $data[$key]['classes'] = $value->getClasse()->getLibelle();
            $data[$key]['appel'] = $value->getAppel();
            //recuperer les presents de la session
            $presents = $entityManager->getRepository(Abscences::class)->findBy(array(
                'session' => $value->getId(),
                'etat' => 'present'
            ));
            $data[$key]['totalPresent'] = count($presents);
            //recuperer les abs de la session
            $abs = $entityManager->getRepository(Abscences::class)->findBy(array(
                'session' => $value->getId(),
                'etat' => 'abs'
            ));
            $data[$key]['totalAbs'] = count($abs);

            //recuperer les eleves de la session
            $eleveSession = $entityManager->getRepository(User::class)->findBy(array(
                'classes' => $value->getClasse(),
            ));

            $data[$key]['eleves'] = array();
            foreach ($eleveSession as $cle=> $valeur){
                $data[$key]['eleves'][$cle]['nom'] = $valeur->getNom();
                $data[$key]['eleves'][$cle]['prenom'] = $valeur->getPrenom();}




        }

        $response = new JsonResponse($data);
        return $response;
    }
}