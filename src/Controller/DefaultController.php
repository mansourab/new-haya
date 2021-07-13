<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Contact;
use App\Entity\Property;
use App\Form\SearchForm;
use App\Repository\ContactRepository;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="app_home")
     */
    public function index(PropertyRepository $repo) : Response
    {
        $latestProperties = $repo->FindLatestProperties();

        $latestForRent = $repo->findLatestRent();

        $properties = $repo->findAll();

        return $this->render('home/index.html.twig', [
            'latest_properties' => $latestProperties,
            'properties' => $properties,
            'latest_rent' => $latestForRent,
        ]);
    }

    /**
     * @Route("/annonce/detail/{slug}", name="app_annonce_detail")
     */
    public function detail(Property $property)
    {
        return $this->render('detail/index.html.twig', [
            'property' => $property
        ]);
    }

    /**
     * @Route("/annonces-immobilieres", name="app_annonces")
     * @return Response
     */
    public function list(PropertyRepository $repo, Request $request): Response
    {
        $data = new SearchData;

        $data->page = $request->get('page', 1);

        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        $properties = $repo->findSearch($data);


        return $this->render('list/index.html.twig', [
            'properties' => $properties,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/a-propos", name="app_about")
     * @return [type] [description]
     */
    public function about()
    {
        return $this->render('about/index.html.twig');
    }

    /**
     * @Route("/contact", name="app_contact")
     * @return [type] [description]
     */
    public function contact(ContactRepository $repository)
    {
        $contacts = $repository->activate();

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts
        ]);
    }

    /**
     * @Route("/coming-soon", name="app_coming_soon")
     * @return Response
     */
    public function coming()
    {
        return $this->render('soon/index.html.twig');
    }

}