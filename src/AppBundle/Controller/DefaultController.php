<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Convenience;
use AppBundle\Entity\Location;
use AppBundle\Entity\Project;
use AppBundle\Entity\Property;
use AppBundle\Entity\Rental;
use AppBundle\Entity\Sale;
use AppBundle\Entity\Tag;
use AppBundle\Entity\Type;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $properties = $em->getRepository(Property::class)
            ->findBy([], ['id' => 'DESC'], 5, 0);

        $projects = $em->getRepository(Project::class)
            ->findAll();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', ['properties' => $properties, 'projects' => $projects]);
    }

    /**
     * @Route("/ajouter-propriete", name="add_property")
     */
    public function createPropertyAction(Request $request)
    {

        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $types = $em->getRepository(Type::class)->findAll();

        $locations = $em->getRepository(Location::class)->findAll();

        $conveniences = $em->getRepository(Convenience::class)->findAll();


        // action to call view add property
        return $this->render('default/add-property.html.twig',
            [
                'types' => $types,
                'locations' => $locations,
                'conveniences' => $conveniences
            ]
        );
    }

    /**
     * @param Request $request
     * @Route("/sauvegarder-propriete", name="save_property")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function savePropertyAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $posts = $request->request->all();
        $posts = $this->cleanAll($posts);

        $property = new Property();
        $property->setTitle($posts['title']);
        $property->setDescription($posts['description']);
        $property->setYear((int) $posts['year']);
        $property->setBathroom((int) $posts['bathroom']);
        $property->setBedroom((int) $posts['bedroom']);
        $property->setFieldSpace((int) $posts['field_space']);
        $property->setKitchen((int) $posts['kitchen']);
        $property->setLivingSpace((int) $posts['living_space']);
        $property->setSubLocation($posts['sub_location']);
        $property->setImages($posts['uploads']);

        /** @var Location $location */
        $location = $em->getRepository(Location::class)->find((int) $posts['location']);
        $property->setLocation($location);

        $type = $em->getRepository(Type::class)->find($posts['type']);
        $property->setType($type);
        $convenienceRepository = $em->getRepository(Convenience::class);

        foreach ($posts['conveniences'] as $convenienceId) {
            $convenience = $convenienceRepository->find((int) $convenienceId);
            $property->addConvenience($convenience);
        }

        $price = $posts['sale_price'];

        if(empty($price)){
            $rental = new Rental();
            $rental->setAdvance($posts['rent_advance']);
            $rental->setDeposit($posts['rent_deposit']);
            $rental->setMonthly($posts['rent_monthly']);
            $property->setRental($rental);
            $em->persist($rental);
        }else{
            $sale = new Sale();
            $sale->setPrice($posts['sale_price']);
            $sale->setDebate(true);
            $property->setSale($sale);
            $em->persist($sale);
        }

        $em->persist($property);
        $em->flush();

        $this->addFlash('success', 'La propriété a été enregistrée avec succes');

        return $this->redirectToRoute('add_property');

    }

    private function clean($string)
    {
        return trim(strip_tags($string));
    }

    private function cleanAll(array $strings)
    {
        return array_map(function ($string)
        {
            if(is_array($string)){
                return $this->cleanAll($string);
            }elseif (is_string($string))
            {
                return $this->clean($string);
            }
            return $string;
        }, $strings);
    }

    /**
     * @Route("/connexion", name="login")
     */
    public function loginAction(request $request)
    {
        return $this->render('default/login.html.twig');
    }

    /**
     * @Route("/page-des-biens/{page}", name="property")
     * @param Request $request
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pageProperty(request $request, $page = 1)
    {
        $max = 12;
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Property::class);
        $properties = $repository->loadProperties($max, $page);
        return $this->render('default/property.html.twig', ['properties' => $properties, 'page' => $page, 'max' => $max]);
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function registerAction(request $request)
    {
        return $this->render('default/register.html.twig');
    }

    /**
     * @Route("/upload-from-trumbowyg", name="upload_from_trumbowyg")
     */
    public function uploadFromTrumbowygAction(Request $request){
        $file = $request->files->get('image');
        return new JsonResponse($this->update($file));
    }

    /**
     * @Route("/upload-from-dropzone", name="upload_from_dropzone")
     */
    public function uploadFromDropzoneAction(Request $request){
        $file = $request->files->get('file');
        return new JsonResponse($this->update($file));
    }

    /**
     * @Route("/remove-upload", name="remove_upload")
     * @param Request $request
     * @return JsonResponse
     */
    public function removeUploadAction(Request $request){
        $file = $request->request->get('url');
        $filename = basename($file);
        $uploadDirectory = $this->getParameter('kernel.project_dir').'/web/uploads';
        try{
            unlink($uploadDirectory.'/'.$filename);
            $result = 'ok';
        }catch (\Exception $e){
            $result = $e->getMessage();
        }
        return new JsonResponse([$result]);
    }

    private function update($file){
        if(null !== $file && $file instanceof UploadedFile){
            $extension = $file->guessClientExtension();
            $extension = $this->clean($extension);
            $uniqid = uniqid('', true);
            $uploadDirectory = $this->getParameter('kernel.project_dir').'/web/uploads';
            $filename = $uniqid.'.'.$extension;
            $file->move($uploadDirectory, $filename);
            $manager = $this->get('assets.packages');
            return [
                'success' => true,
                'file' => $manager->getUrl('uploads/'.$filename)
            ];
        }

        return [
            'success' => false
        ];
    }

    /**
     * @Route("/ajouter-projet", name="add_project")
     */
    public function addProjectAction(request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository(Tag::class)->findAll();

        return $this->render('default/add-project.html.twig', ['tags' => $tags]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(request $request)
    {
        return $this->render('default/contact.html.twig');
    }

    /**
     * @Route("/projets", name="projects")
     */
    public function projectsAction(request $request)
    {
        return $this->render('default/projects.html.twig');
    }

    /**
     * @Route("/profile/{username}", name="myaccount")
     */
    public function myAccountAction(request $request, $username)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);

        return $this->render('default/myaccount.html.twig', ['user' => $user]);
    }

    /**
     * @param Request $request
     * @Route("/sauvegarder-utilisateur", name="save_user")
     */
    public function saveUserAction(request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $request->request->all();
        $posts = $this->cleanAll($posts);

        if(false === $this->check($posts)){
            return $this->redirectToRoute('register');
        }

        $user = new User();
        $user->setEmail($posts['email']);
        $user->setPassword(hash('sha512', $posts['password']));
        $user->setUsername($posts['username']);
        $user->setLastname($posts['nom']);
        $user->setFirstname($posts['prenoms']);


        $user->setPhone($posts['phone']);

        $em->persist($user);
        $em->flush();
        $this->addFlash('success', 'Vous avez été enregistré avec success');
        return $this->redirectToRoute('myaccount', ['username' => $user->getUsername()]);

    }

    private function check(array $posts){
        /* On verifie que les données obligatoires sont presentes */
        $required = ['username', 'email', 'password', 'confirm', 'phone'];
        foreach ($required as $post) {
            if( false === array_key_exists($post, $posts) || empty( $posts[$post] ) ){
                $this->addFlash('danger', 'La case '.$post.' ne peut pas être vide');

                return false;
            }
        }

        /* On verifie que le nom d'utilisateur est correcte:
          - il commence par un caracteres alphabetique
          - il contient pas de charactere vide
          - il fait entre 6 et 32 caracteres
         */
        if ( !preg_match('/^[A-Za-z][A-Za-z0-9]{4,31}$/', $posts['username']) ){
            $this->addFlash('danger', "le nom d'utilisateur ne peut pas contenir d'espace vide ou commencer par un chiffre");
            return false;
        }

        $em = $this->getDoctrine()->getManager();
        $userRepository = $user = $em->getRepository(User::class);

        /* On verifie que le nom d'utilisateur n'existe pas deja */
        $user = $userRepository->findOneBy(['username' => $posts['username']]);
        if(null !== $user){
            $this->addFlash('danger', "le nom d'utilisateur existe deja");
            return false;
        }

        /* On verifie que le email n'existe pas deja */
        $user = $userRepository->findOneBy(['email' => $posts['email']]);
        if(null !== $user){
            $this->addFlash('danger', "l'email existe deja");
            return false;
        }


        /* On verifie que l'email est correcte */
        if (!filter_var($posts['email'], FILTER_VALIDATE_EMAIL)) {
            $this->addFlash('danger', "l'email est incorrecte");
            return false;
        }

        /* on verifie que le mot de passe et la confirmation ne sont pas different */
        if($posts['password'] !== $posts['confirm']){
            $this->addFlash('danger', 'les mots de passes saisis ne correspondent pas');
            return false;
        }

        /* On verifie si l'utilisateur a accepté les cgu */
        if(false === array_key_exists('accepter', $posts)){
            $this->addFlash('danger', 'Vous devez accepter les cgu');
            return false;
        }

        /* on verifie que le mot de passe est correct */
        $uppercase = preg_match('@[A-Z]@', $posts['password']);
        $lowercase = preg_match('@[a-z]@', $posts['password']);
        $number    = preg_match('@[0-9]@', $posts['password']);

        if(!$uppercase || !$lowercase || !$number || strlen($posts['password']) < 8) {
            $this->addFlash('danger', 'Le mot de passe doit contenir: au moins une lettre majuscule, une lettre minuscule, un chiffre et doit faire au moins 8 caracteres');
            return false;
        }

        return true;

    }

    /**
     * @Route("/liste-des-projets", name="investissement")
     */
    public function displayProjectsAction(request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository(Project::class)->findAll();
        $tags = $em->getRepository(Tag::class)->findAll();

        return $this->render('default/investissement.html.twig', ['projects' => $projects,'tags' => $tags]);

    }

    /**
     * @Route("/detail-projet/{id}", name="detail_project")
     */
    public function detailProjectsAction(request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $project = $em->find(Project::class, $id);

        if(null === $project){
            throw $this->createNotFoundException('Projet inconnu');
        }


        $repository = $em->getRepository(Project::class);
        $qb = $repository->createQueryBuilder('p');
        $qb->orderBy('p.id', 'ASC')
            ->setMaxResults(1);
        $qb->where('p.id > :id')
            ->setParameter('id', (int) $id);
        $next = $qb->getQuery()->getOneOrNullResult();


        $qb = $repository->createQueryBuilder('p');
        $qb->orderBy('p.id', 'DESC')
            ->where('p.id < :id')
            ->setParameter('id', (int) $id)
            ->setMaxResults(1);
        $previous = $qb->getQuery()->getOneOrNullResult();

        return $this->render('default/detail-project.html.twig', [
            'project' => $project,
            'next' => $next,
            'previous' => $previous
        ]);

    }

    /**
     * @Route("/enregistrer-projet", name="save_project")
     */
    public function saveProjectAction(request $request){
        $posts = $request->request->all();
        $description = $posts['description'];
        $posts = $this->cleanAll($posts);

        $project = new Project();
        $project->setTitle($posts['title']);
        $project->setDescription($description);
        $project->setLocation($posts['location']);
        $project->setSchedule($posts['schedule']);
        $project->setAuthor($posts['author']);
        $project->setImages($posts['uploads']);
        $project->setSubtitle($posts['subtitle']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        return $this->redirectToRoute('detail_project', ['id' => $project->getId()]);

    }

}

