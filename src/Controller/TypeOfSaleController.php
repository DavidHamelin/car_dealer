<?php

namespace App\Controller;

use App\Entity\TypeOfSale;
use App\Form\TypeOfSaleType;
use App\Repository\TypeOfSaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/of/sale")
 */
class TypeOfSaleController extends AbstractController
{
    /**
     * @Route("/", name="app_type_of_sale_index", methods={"GET"})
     */
    public function index(TypeOfSaleRepository $typeOfSaleRepository): Response
    {
        return $this->render('type_of_sale/index.html.twig', [
            'type_of_sales' => $typeOfSaleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_type_of_sale_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TypeOfSaleRepository $typeOfSaleRepository): Response
    {
        $typeOfSale = new TypeOfSale();
        $form = $this->createForm(TypeOfSaleType::class, $typeOfSale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeOfSaleRepository->add($typeOfSale);
            return $this->redirectToRoute('app_type_of_sale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_of_sale/new.html.twig', [
            'type_of_sale' => $typeOfSale,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_of_sale_show", methods={"GET"})
     */
    public function show(TypeOfSale $typeOfSale): Response
    {
        return $this->render('type_of_sale/show.html.twig', [
            'type_of_sale' => $typeOfSale,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_of_sale_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeOfSale $typeOfSale, TypeOfSaleRepository $typeOfSaleRepository): Response
    {
        $form = $this->createForm(TypeOfSaleType::class, $typeOfSale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeOfSaleRepository->add($typeOfSale);
            return $this->redirectToRoute('app_type_of_sale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_of_sale/edit.html.twig', [
            'type_of_sale' => $typeOfSale,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_of_sale_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeOfSale $typeOfSale, TypeOfSaleRepository $typeOfSaleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeOfSale->getId(), $request->request->get('_token'))) {
            $typeOfSaleRepository->remove($typeOfSale);
        }

        return $this->redirectToRoute('app_type_of_sale_index', [], Response::HTTP_SEE_OTHER);
    }
}
