<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     * @Route("/books/list")
     * @Method("GET")
     */
    public function readAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository('AppBundle:Book')
            ->findAll();

        return $this->createApiResponse($books);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     * @Route("/books/new")
     * @Method({"POST", "OPTIONS"})
     */
    public function createAction(Request $request)
    {
        $book = new Book();
        $form = $this->createForm('AppBundle\Form\BookType', $book);

        $this->processForm($request, $form);

        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        return $this->createApiResponse($book);
    }

    /**
     * @param Request $request
     * @param string $bookName
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException|NotFoundHttpException|\InvalidArgumentException|AlreadySubmittedException
     * @Route("/books/edit/{bookName}")
     * @Method({"PUT", "OPTIONS"})
     */
    public function updateAction(Request $request, $bookName)
    {
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository('AppBundle:Book')
            ->findOneBy(['name' => $bookName]);

        if (!$book) {
            throw $this->createNotFoundException(sprintf(
                'No book was found by the name "%s"',
                $bookName
            ));
        }

        $form = $this->createForm('AppBundle\Form\UpdateBookType', $book);
        $this->processForm($request, $form);

        $em->persist($book);
        $em->flush();

        return $this->createApiResponse($book);
    }

    /**
     * @param string $bookName
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException|NotFoundHttpException|\InvalidArgumentException
     * @Route("/books/remove/{bookName}")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteAction($bookName)
    {
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository('AppBundle:Book')
            ->findOneBy(['name' => $bookName]);

        if ($book) {
            $em->remove($book);
            $em->flush();
        }

        return new Response(null, 204);
    }

    /**
     * @param string $bookName
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException|NotFoundHttpException|\InvalidArgumentException
     * @Route("/books/{bookName}")
     * @Method("GET")
     */
    public function readAction($bookName)
    {
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository('AppBundle:Book')
            ->findOneBy(['name' => $bookName]);

        if (!$book) {
            throw $this->createNotFoundException(sprintf(
                'No book was found by the name "%s"',
                $bookName
            ));
        }

        return $this->createApiResponse($book);
    }

    /**
     * @param Request $request
     * @param FormInterface $form
     * @throws AlreadySubmittedException|\LogicException
     */
    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);

        $form->submit($data);
    }
}