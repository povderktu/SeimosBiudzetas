<?php

namespace App\Controller;

use App\Entity\Expanse;
use App\Entity\ExpanseType;
use App\Entity\Member;
use App\Form\ExpanseFormType;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;



class ExpanseController extends AbstractController
{
    /**
     * @Route("/expanse/{id}", name="expanse")
     */
    public function ShowExpanseOfMember($id)
    {
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {

                $em = $this->getDoctrine()->getManager();
                $member = $em->getRepository(Member::class)->findOneBy(['id' => $id]);

                if(!$member) {
                    throw $this->createNotFoundException('404 error. This page does not exist.');
                }

                $expanses = $em->getRepository(Expanse::class)->findBy(array('member' => $member));

                return $this->render('/expanses.html.twig', [
                    'expanses' => $expanses,
                ]);
            }
        }
            return $this->redirectToRoute('main');
    }

    /**
     * @Route("/addexpanse", name="addexpanse")
     */
    public function AddExpanse(Request $request)
    {
        $error = "";
        $summ = "";
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 1) {
                $user = $this->getUser();
                if ($user && $this->getUser()->getLimitas() > 0) {
                    $expanse = new Expanse();
                    $form = $this->createForm(ExpanseFormType::class, $expanse);
                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) {
                        $user = $this->getUser();
                        $limit = $user->getDabartinisLimitas();
                        $suma = $expanse->getSuma();
                        $limit = $limit - $suma;
                        if ($limit < 0) {
                            $error = "Per didelė pirkinio/išlaidos suma, viršija jūsų limitą.";
                            return $this->render(
                                'addExpanse.html.twig',
                                array('form' => $form->createView(),
                                    'error' => $error,
                                )
                            );
                        } else {
                            $user->setDabartinisLimitas($limit);
                            $expanse->setMember($user);
                        }
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($expanse);
                        $entityManager->flush();

                        return $this->redirectToRoute('showmyexpanses');
                    }
                    elseif($form->isSubmitted() && !$form->isValid()) {
                        $summ = "Netinkamas sumos formatas. Sumos įvedimui naudokite tik skaičius (pvz. 8 arba 7.26)";
                    }
                    return $this->render(
                        'addExpanse.html.twig',
                        array('form' => $form->createView(),
                            'error' => $error,
                            'summ' => $summ,
                        )
                    );
                }
            }
        }
            return $this->redirectToRoute('main');
    }
    /**
     * @Route("/showmyexpanses", name="showmyexpanses")
     */
    public function ShowMyExpanses()
    {
        if($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 1) {
                $em = $this->getDoctrine()->getManager();
                $expanses = $em->getRepository(Expanse::class)->findBy(['member' => $this->getUser()]);
                return $this->render('/expansesv2.html.twig', [
                    'expanses' => $expanses,
                ]);
            }
        }
        else{
            return $this->redirectToRoute('main');
        }
    }
    /**
     * @Route("/changelimit/{id}", name="changeLimit")
     */
    public function changeLim($id, Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {

                $em = $this->getDoctrine()->getManager();
                $member = $em->getRepository(Member::class)->find($id);
                if (!$member) {
                    throw $this->createNotFoundException(
                        'No product found for id ' . $id
                    );
                }
                $form = $this->createFormBuilder()
                    ->add('limit', MoneyType::class)
                    ->getForm();
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $data = $form->getData();
                    $member->setLimitas($data['limit']);
                    $em->flush();

                    return $this->redirectToRoute('MembersList');
                }
                return $this->render(
                    'changeLimit.html.twig',
                    array(
                        'form' => $form->createView(),
                    ));
            }
        }
        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/changelimstate", name="changelimstate")
     */
    public function changeLimState()
    {
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $members = $this->getDoctrine()->getRepository(Member::class)->findAll();
            return $this->render(
                'changeLimitState.html.twig',
                array('members' => $members)
            );
        }
        return $this->redirectToRoute('main');
    }




}
