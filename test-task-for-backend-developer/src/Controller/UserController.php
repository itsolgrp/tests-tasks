<?php

namespace App\Controller;

use App\Entity\User;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/user")
 * @IsGranted({"ROLE_OWNER", "ROLE_MANAGER", "ROLE_LEADER"})
 */
class UserController extends AbstractController
{

    /**
     * @Route("/", name="user", methods={"GET"})
     */
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        if ($this->isGranted('ROLE_MANAGER')) {
            $users = $userRepository->findBy([
                'position' => ['Kaupluse juht', 'Kassapidaja', 'Remontija', 'Assistent']
            ]);
        } else if ($this->isGranted('ROLE_LEADER')) {
            $users = $userRepository->findBy([
                'position' => ['Kassapidaja', 'Assistent']
            ]);
        }
        return $this->render('user/user.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $password_encoder): Response
    {
        $user = new User;

        $form = $this->createForm(UserType::class, $user, ['role' => $this->getUser()->getRoles()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user->setName($form->get('name')->getData());
            $user->setLastname($form->get('lastname')->getData());
            $user->setPersonalCode($form->get('personalCode')->getData());
            $user->setPhone($form->get('phone')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setCode($form->get('code')->getData());
            $position = $form->get('position')->getData();
            switch ($position) {
                case "Omanik":
                    $role = "OWNER";
                    break;
                case "Direktor":
                    $role = "MANAGER";
                    break;
                case "Kaupluse juht":
                    $role = "LEADER";
                    break;
                case "Kassapidaja":
                    $role = "WORKER";
                    break;
                case "Remontija":
                    $role = "REPAIRER";
                    break;
                case "Assistent":
                    $role = "ASSISTANT";
                    break;
            }
            $user->setPosition($position);
            $user->setRoles(array('ROLE_' . $role));
            $user->setUsername($form->get('username')->getData());
            $user->setBirthday(Carbon::parse($form->get('birthday')->getData()));


            $password = $password_encoder->encodePassword($user,
                $form->get('plainPassword')->get('first')->getData());

            $user->setPassword($password);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/user_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/user_show.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $password_encoder): Response
    {
        $form = $this->createForm(UserType::class, $user, ['role' => $this->getUser()->getRoles()])->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user->setName($form->get('name')->getData());
            $user->setLastname($form->get('lastname')->getData());
            $user->setPersonalCode($form->get('personalCode')->getData());
            $user->setPhone($form->get('phone')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setCode($form->get('code')->getData());
            $position = $form->get('position')->getData();
            switch ($position) {
                case "Omanik":
                    $role = "OWNER";
                    break;
                case "Direktor":
                    $role = "MANAGER";
                    break;
                case "Kaupluse juht":
                    $role = "LEADER";
                    break;
                case "Kassapidaja":
                    $role = "WORKER";
                    break;
                case "Remontija":
                    $role = "REPAIRER";
                    break;
                case "Assistent":
                    $role = "ASSISTANT";
                    break;
            }
            $user->setPosition($position);
            $user->setRoles(array('ROLE_' . $role));
            $user->setUsername($form->get('username')->getData());

            $user->setBirthday(Carbon::parse($form->get('birthday')->getData()));


            $password = $password_encoder->encodePassword($user, $form->get('plainPassword')->get('first')->getData());

            $user->setPassword($password);

            $entityManager->flush();

            $this->addFlash('success', 'Töötaja andmed on uuendatud!');

            return $this->redirectToRoute('user_edit', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('user/user_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete-user', $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Töötaja andmed on kustutatud!');

        return $this->redirectToRoute('user');
    }

}
