<?php
/**
 * Created by PhpStorm.
 * User: Eliket-Grp
 * Date: 02/10/2018
 * Time: 17:13
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Location;
use AppBundle\Entity\Type;
use AppBundle\Form\LocationType;
use AppBundle\Entity\Property;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_index")
     */
    public function indexAction(){
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/properties", name="admin_list_property")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listPropertyAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $page = $request->query->get('page');

        $page = $page ?? 1;
        $properties = $em->getRepository(Property::class)->loadProperties(20, null, (int) $page, false);

        return $this->render('admin/list-property.html.twig', ['properties' => $properties]);
    }


    /**
     * @param Request $request
     * @param $propertyId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @Route("/publish-property/{propertyId}", name="admin_publish_property")
     */
    public function publishAction(Request $request, $propertyId){
        $published = $request->query->get('published');
        $published = trim(strip_tags($published));
        $em = $this->getDoctrine()->getManager();
        $property = $em->find(Property::class, (int) $propertyId);
        if(null === $property){
            throw $this->createNotFoundException('Propriété non trouvée');
        }

        $property->setPublished(!!$published);
        $em->persist($property);
        $em->flush();

        return $this->json(['result' => 'OK']);

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/list-location", name="admin_list_location_and_add")
     */
    public function locationAndTypeAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $locations = $em->getRepository(Location::class)->findAll();
        $types = $em->getRepository(Type::class)->findAll();

        return $this->render('admin/list-location.html.twig',[
            'locations' => $locations,
            'types' => $types
        ]);

    }


    /**
     * @param Request $request
     * @param $entity
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("add-location-or-property-type/{entity}", name="add_location_or_property_type")
     */
    public function addLocationOrPropertyTypeAction(Request $request, $entity){
        $em = $this->getDoctrine()->getManager();
        $title = $this->clean($request->request->get('title'));
        $object = $entity === 'location' ? new Location() : new Type();
        $object->setTitle($title);
        $em->persist($object);
        $em->flush();
        return $this->redirectToRoute('admin_list_location_and_add');
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
}
