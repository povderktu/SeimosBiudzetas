<?php

namespace App\Controller;

use App\Entity\Expanse;
use App\Entity\ExpanseType;
use App\Entity\Member;
use App\Form\ExpanseTypeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;

class ExpanseTypeController extends AbstractController
{
    /**
     * @Route("/addExpanseType", name="addExpanseType")
     */
    public function addExpanseType(Request $request)
    {
        $error = "";
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {
                $user = $this->getUser();
                    $expanseType = new ExpanseType();
                    $form = $this->createForm(ExpanseTypeType::class, $expanseType);
                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) {
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($expanseType);
                        $entityManager->flush();
                        return $this->redirectToRoute('ExpanseTypesList');
                    }
                    return $this->render(
                        'addExpanseType.html.twig',
                        array('form' => $form->createView(),
                        )
                    );
            }
        }
        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/types/{id}/expanses", name="expanses")
     */
    public function ShowExpansesOfCategory($id)
    {
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {

                $em = $this->getDoctrine()->getManager();
                $type = $em->getRepository(ExpanseType::class)->findOneBy(['id' => $id]);
                if(!$type) {
                    throw $this->createNotFoundException('404 error. This page does not exist.');
                }

                $expanses = $em->getRepository('App:ExpanseType')->find($id)->getExpanses();

                //$expanses = $em->getRepository('App:ExpanseType')->

                return $this->render('/expansesCategory.html.twig', [
                    'expanses' => $expanses,
                ]);
            }
        }
        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/expanseTypes", name="ExpanseTypesList")
     */
    public function ExpanseTypesList()
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {
                $expanseTypes = $this->getDoctrine()->getRepository(ExpanseType::class)->findAll();
                return $this->render(
                    'expanseTypes.html.twig',
                    array('expanseTypes' => $expanseTypes)
                );
            }
        }
        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/deleteExpanseType/{id}", name="deleteExpanseType")
     */
    public function deleteExpanseType($id, Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {

                $em = $this->getDoctrine()->getManager();
                $expanseType = $em->getRepository(ExpanseType::class)->find($id);
                $em->remove($expanseType);
                $em->flush();

                return $this->redirectToRoute('ExpanseTypesList');
            }
        }
        return $this->redirectToRoute('main');
    }
}
