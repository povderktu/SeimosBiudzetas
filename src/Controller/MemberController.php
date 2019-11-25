<?php

namespace App\Controller;

use App\Entity\Expanse;
use App\Repository\ExpanseRepository;
use function PHPSTORM_META\type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Member;
use App\Form\MemberType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\Query;
use App\Repository\MemberRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;

class MemberController extends AbstractController
{
    public function getXml(): XmlEncoder
    {
        return new XmlEncoder();
    }

    /**
     * @Route("/members", name="MembersList")
     */
    public function MembersList()
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {
                $members = $this->getDoctrine()->getRepository(Member::class)->findAll();
                return $this->render(
                    'members.html.twig',
                    array('members' => $members)
                );
            }
        }
        return $this->redirectToRoute('main');
    }
    /**
     * @Route("/register", name="register")
     */
    public function Register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {
                $member = new Member();
                if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                    $form = $this->createForm(MemberType::class, $member);

                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) {
                        $member->setLimitas(0);
                        $member->setDabartinisLimitas(0);
                        $member->setBusena('Nepatvirtintas');
                        $member->setReason('');
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($member);
                        $em->flush();

                        return $this->redirectToRoute('MembersList');
                    }
                    return $this->render('register.html.twig',
                        array('form' => $form->createView()));
                }
            }
        }
        return $this->redirectToRoute('main');
    }


    /**
     * @Route("/blockLimit/{id}", name="blockLimit")
     */
    public function blockLimit($id, Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 2) {

                $em = $this->getDoctrine()->getManager();
                $member = $em->getRepository(Member::class)->find($id);
                if (!$member) {
                    throw $this->createNotFoundException(
                        'No member found for id ' . $id
                    );
                }
                $form = $this->createFormBuilder()
                    ->add('reason', TextType::class)
                    ->getForm();
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $data = $form->getData();
                    $member->setReason($data['reason']);
                    $member->setBusena('Užblokuotas');
                    $em->flush();

                    return $this->redirectToRoute('changelimstate');
                }
                return $this->render(
                    'blockLimit.html.twig',
                    array(
                        'form' => $form->createView(),
                    ));
            }
        }
        return $this->redirectToRoute('main');
    }
        /**
         * @Route("/confirmLimit/{id}", name="confirmLimit")
         */
        public function confirmLimit($id, Request $request)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 2) {

                $em = $this->getDoctrine()->getManager();
                $member = $em->getRepository(Member::class)->find($id);
                $member->setBusena('Patvirtintas');
                $em->flush();

                return $this->redirectToRoute('changelimstate');
                }
            }
        return $this->redirectToRoute('main');
        }
        /**
        * @Route("/deleteUser/{id}", name="deleteUser")
        */
        public function deleteUser($id, Request $request)
        {
            if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                if ($this->getUser()->getrole() == 3) {

                    $em = $this->getDoctrine()->getManager();
                    $member = $em->getRepository(Member::class)->find($id);
                    $em->remove($member);
                    $em->flush();

                    return $this->redirectToRoute('MembersList');
                }
            }
            return $this->redirectToRoute('main');
        }

    /**
     * @Route("/deleteUserExp/{id}", name="deleteUserExp")
     */
    public function deleteUserExp(ExpanseRepository $repository, $id)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {

                $repository->removeCreatedP($id);
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                return $this->redirectToRoute('MembersList');
            }
            }
        return $this->redirectToRoute('main');
    }

        /**
         * @Route("/resetLimits", name="resetLimits")
         */
        public function resetLimits(MemberRepository $repository)
        {
            if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                if ($this->getUser()->getrole() == 3) {

                    $plops = $repository->getCreatedP();
                    $em = $this->getDoctrine()->getManager();
                    foreach($plops as $pl)
                    {
                        $limit=$pl->getLimitas();
                        $pl->setDabartinisLimitas($limit);
                        $em->flush();

                    }

                    return $this->redirectToRoute('MembersList');
                }
            }
            return $this->redirectToRoute('main');
        }

    /**
     * @Route("/clearLimits", name="clearLimits")
     */
    public function clearLimits(MemberRepository $repository)
    {
        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {

                $plops = $repository->getCreatedP();
                $em = $this->getDoctrine()->getManager();
                foreach($plops as $pl)
                {
                    $pl->setLimitas(0);
                    $pl->setDabartinisLimitas(0);
                    $em->flush();

                }

                return $this->redirectToRoute('MembersList');
            }
        }
       return $this->redirectToRoute('main');
    }
    /**
     * @Route("/login", name="login")
     */
    public function Login(Request $request, AuthenticationUtils $authenticationUtils, AuthorizationCheckerInterface $authorizationChecker)
    {
        if($authorizationChecker->isGranted('ROLE_USER')){
            return $this->redirectToRoute('main');
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'login.html.twig',
            array('last_username' => $lastUsername,
                'error' => $error,
            ));
    }

}
