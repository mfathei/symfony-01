<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\User;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/micro-post")
 */
class MicroPostController extends AbstractController
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var MicroPostRepository
     */
    private $microPostRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RouterInterface $router
     */
    private $router;

    /**
     * @var FlashBagInterface $flashBag
     */
    private $flashBag;

    /**
     * @var AuthorizationChecker $authorizationChecker
     */
    private $authorizationChecker;

    public function __construct(\Twig_Environment $twig,
                                MicroPostRepository $microPostRepository,
                                FormFactoryInterface $formFactory,
                                EntityManagerInterface $entityManager,
                                RouterInterface $router,
                                FlashBagInterface $flashBag,
                                AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->twig = $twig;
        $this->microPostRepository = $microPostRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @Route("/", name="micro_post_index")
     */
    public function index()
    {
        $posts = $this->microPostRepository->findBy([], ['time' => 'desc']);

        $html = $this->twig->render('micro-post/index.html.twig', [
            'posts' => $posts
        ]);

        return new Response($html);
    }

    /**
     * @Route("/add", name="micro_post_add")
     * @Security("is_granted('ROLE_USER')")
     */
    public function add(Request $request, TokenStorageInterface $tokenStorage)
    {
        $microPost = new MicroPost();
        $user = $tokenStorage->getToken()->getUser();
        $microPost->setUser($user);
        $form = $this->formFactory->create(MicroPostType::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $microPost->setTime(new \DateTime());

            $this->entityManager->persist($microPost);
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('micro_post_index'));
        }

        return new Response($this->twig->render('micro-post/add.html.twig',
            [
                'form' => $form->createView()
            ]
        ));
    }

    /**
     * @Route("/user/{username}", name="user_micro_posts")
     */
    public function userPosts(User $user)
    {
//        $posts = $this->microPostRepository->findBy(['user' => $user], ['time' => 'desc']);

        $posts = $user->getPosts();// lazy loading

        return new Response($this->twig->render('micro-post/user-posts.html.twig', ['posts' => $posts]));
    }

    /**
     * @Route("/{id}", name="micro_post_post")
     */
    public function post($id)
    {
        $post = $this->microPostRepository->find($id);

        return new Response(
            $this->twig->render('micro-post/post.html.twig', ['post' => $post])
        );
    }

    /**
     * @Route("/{id}/edit", name="micro_post_edit")
     * @Security("is_granted('edit', microPost)", message="Access Denied")
     */
    public function edit(MicroPost $microPost, Request $request)
    {
        //$this->denyAccessUnlessGranted('edit', $microPost);
        //if (!$this->authorizationChecker->isGranted('edit', $microPost)) {
        //   throw new AccessDeniedException('Access Denied');
        //}
        $form = $this->formFactory->create(MicroPostType::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('micro_post_index'));
        }

        return new Response($this->twig->render('micro-post/add.html.twig',
            [
                'form' => $form->createView()
            ]
        ));
    }

    /**
     * @Route("/{id}/delete", name="micro_post_delete")
     * @Security("is_granted('delete', microPost)", message="Access Denied")
     */
    public function delete(MicroPost $microPost)
    {
        //$this->denyAccessUnlessGranted('delete', $microPost);
        //if (!$this->authorizationChecker->isGranted('delete', $microPost)) {
        //   throw new AccessDeniedException('Access Denied');
        //}
        $this->entityManager->remove($microPost);
        $this->entityManager->flush();

        $this->flashBag->add('notice', 'Post deleted successfully!');

        return new RedirectResponse($this->router->generate('micro_post_index'));
    }
}
