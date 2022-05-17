<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarSearch;
use App\Form\AdminCarType;
use App\Form\AdminNewCarType;
use App\Form\CarSearchType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/car")
 */
class AdminCarController extends AbstractController
{

    /**
     * @var string
     */
    private $img_path = '/uploads/images/cars/';

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }
    /**
     * @Route("/", name="app_admin_car")
     */
    public function index(Request $request): Response
    {
        $carSearch = new CarSearch();
        $form = $this->createForm(CarSearchType::class, $carSearch);
        $form->handleRequest($request); // get request


        $cars = $this->carRepository->findByOptions($carSearch);

        $searchTitle = "Liste des voitures disponibles";
        if ($form->isSubmitted() && $form->isValid()) {
            $searchTitle = "Liste de voitures filtrée par ";

            // !empty($request->request->get("energyOption")) : avec methode getBlockPrefix dans CarSearchType
            if (isset($_POST["car_search"]["energyOption"]) && count($_POST["car_search"]["energyOption"]) > 0) {
                $searchTitle .= "Type de carburant, ";
            }
            if (isset($_POST["car_search"]["seat"]) && count($_POST["car_search"]["seat"]) > 0) {
                $searchTitle .= "Nombre de places, ";
            }
            if (isset($_POST["car_search"]["km"]) && $_POST["car_search"]["km"] != null) {
                $searchTitle .= "Kilometres maximum ";
            }
        }
        // dd($request->request);

        // look for *all* cars objects
        // $cars = $this->carRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'searchTitle' => $searchTitle, // appel var
            'cars' => $cars, // appel var
            'form' => $form->createView(),
            'img_path' => $this->img_path
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_admin_car_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Car $car, CarRepository $carRepository): Response
    {

        $form = $this->createForm(AdminCarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->add($car);
            $this->addFlash(
                'Success',
                'Changes saved !'
            );
            return $this->redirectToRoute('app_admin_car');
        }

        return $this->renderForm('admin/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/new", name="admin_new_car", methods={"GET", "POST"})
     */
    public function new(Request $request, CarRepository $carRepository): Response
    {
        $car = new Car();
        $form = $this->createForm(AdminNewCarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->add($car);
            $this->addFlash(
                'Success',
                'Car added to database !'
            );
            return $this->redirectToRoute('app_admin_car');
        }

        return $this->renderForm('admin/new.html.twig', [
            'car' => $car,
            'form' => $form

        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_admin_car_delete", methods={"POST"})
     */
    public function delete(Request $request, Car $car, CarRepository $carRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $car->getId(), $request->request->get('_token'))) {
            $carRepository->remove($car);
            $this->addFlash(
                'Success',
                'Car removed !'
            );
        }

        return $this->redirectToRoute('app_admin_car', [], Response::HTTP_SEE_OTHER);
    }
}
