<?php
// src/Controller/CarController.php
namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarSearch;
use App\Form\CarSearchType;
use App\Repository\CarRepository;
use ContainerW6DEQNo\getEnergyOptionService;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CarController extends AbstractController
{
    /**
     * @var string
     */
    private $userFirstName = 'David';

    // private const carDetails = [
    //     "brand" => "Ferrari",
    //     "model" => "488 GTB",
    //     "year" => "2015",
    //     "engine" => "V8 bi-turbo",
    //     "color" => "rouge"
    // ];

    /**
     * @var array
     */
    private $cars;

    /**
     * @var CarRepository
     */
    private $repository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
        // for($i = 1;$i<=5; $i++)
        // {
        //     $car = new Car();
        //     $car->setId($i);
        //     $car->setBrand("Ferrari".$i);
        //     $car->setModel("488 GTB");
        //     $car->setYear(2015);
        //     $car->setEngine("V8 bi-turbo");
        //     $car->setColor("rouge");
        //     $this->cars[$i] = $car;
        // }
    }

    /**
     * @Route("/car", name="car")
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

        
        return $this->render('Car/index.html.twig', [
            'userFirstName' => $this->userFirstName, // appel var
            'searchTitle' => $searchTitle, // appel var
            'cars' => $cars, // appel var
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/car/details/{slug}/{id}", name="car_details")
     */
    public function show(Car $cars, string $slug): Response
    {
        // dd($cars->getSlug());

        // $cars = $this->carRepository->find($id);

        if ($cars->getSlug() !== $slug) {
            return $this->redirectToRoute('car_details', [
                'id' => $cars->getId(),
                'slug' => $cars->getSlug()
            ]);
        }

        return $this->render('Car/details.html.twig', [
            'userFirstName' => $this->userFirstName, // appel var
            'cars' => $cars, // appel var
        ]);
    }


    // public function index(): Response
    // {
    //     // the template path is the relative file path from `templates/`
    //     return $this->render('Car/index.html.twig', [
    //         // this array defines the variables passed to the template,
    //         // where the key is the variable name and the value is the variable value
    //         // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
    //         'user_first_name' => $this->userFirstName, // appel var
    //         'car_details' => self::carDetails, // appel const
    //     ]);
    // }
}
