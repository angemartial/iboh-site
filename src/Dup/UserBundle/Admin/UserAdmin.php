<?php
namespace Dup\UserBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\Admin;

class UserAdmin extends Admin{

    /**
     * Defines the information to show in the dashboard user admin list 
     * 
     * @param  ListMapper $listMapper The list builder
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username' , 'text', array('label'=>'Pseudo')) //This  will carry the link that leads to item's individual page
            ->add('enabled' , 'boolean', array('label'=>'Activé'))
            ->add('email' , 'text')
            ->add('roles', null,  array('label'=>'Droits'))
        ;
    }

    /**
     * Builds the form for creation and update actions on a user
     * 
     * @param  FormMapper $formMapper Contains the form
     * 
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        //Not required to define a password, in case of update. When updating, the id of the user already exists
        $passwordRequired = is_null($this->getSubject()->getId()) ? true : false;
        $formMapper
        ->with('Utilisateurs')
        ->add('username' , 'text', array('label' => 'Pseudo'))
        ->add('email' , 'text', array('label' => 'Email'))
        ->add('plainPassword', 'repeated' , array(
                'type' => 'password',
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmer le mot de passe'),
                'invalid_message' => 'Les mots de passes ne correspondent pas',
                'required' => $passwordRequired
                )
        )
        ->add('nom' , 'text', array('label' => 'Nom de l\'utilisateur'))
        ->add('prenoms' , 'text', array('label' => 'Prenoms de l\'utilisateur'))
        ->add('birthdate' , 'birthday', array('label' => 'Date de naissance'))
        ->add('enabled', 'choice', 
            array('label' => 'Activer ce compte', 
                'expanded' => true,
                'choices'=>array('1' => 'Maintenant', '0' => 'Plus tard')
            ))
        ->end();
    }

    /**
     * Enables to filter the dashboard user list. Defines the criterias for the filter
     * 
     * @param  DatagridMapper $datagridMapper Contains the criterias
     * 
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('username' , 'doctrine_orm_string', array('label'=>'Pseudo'))
                       ->add('email', 'doctrine_orm_string', array('label'=>'Email'))
                       ->add('enabled', null, array('label'=>'Activé'));
    }

    /**
     * This hook will be executed by Sonata Admin Bundle prior to actually persist the entity in database
     * 
     * @param  User $user   the user (This is the subject of the admin form, it's automatically passed by Sonata Admin)
     *
     */
    public function prePersist($user)
    {
        /*
            We load the FosUserBundle's User Manager, it will hash the password and make some extra opérations on the entity
         */
        $this->get('fos_user.user_manager')->updateUser($user);

        /*
            We loads the DupBaabBundle's parameter manager in charge of dealing with user parameters in the application
            It will initialize the user parameters with default values 
         */
        $this->get('dup_baab_bundle_param_manager')->initUserParams($user);
    }

    /**
     * This hook will be executed by Sonata Admin Bundle before removing the entity from database
     * 
     * @param  User $user 
     * 
     */
    public function preRemove($user)
    {
        /*
            We need to remove the user parameters to the database before the user is deleted
         */
        $this->get('dup_baab_bundle_param_manager')->removeUserParams($user);
    }

    /**
     * Loads the service container from the global variable $kernel and returns a service from the container.
     * 
     * @param  string       $id       The id of the service to load
     *
     * @todo Properly inject dependancies in this service configuration, using the dependancy injection mechanism
     * 
     * @return mixed     The service
     */
    private function get($id){
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        return $kernel->getContainer()->get($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getBatchActions()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureSideMenu(ItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        $user = $this->getSubject();
        $securityContext = $this->get('security.context');
        $tokenUser = $securityContext->getToken()->getUser();
        if ('edit' !== $action || $tokenUser->getId() === $user->getId()) {
            return;
        }
        /*
            We need to provide some menu options to promote or demote a user
         */
        $menuOptions = array(
            'promote-super-admin' => array('role'=>'ROLE_SUPER_ADMIN', 'label' => 'Rendre Super Admin', 'newRole' => 'ROLE_SUPER_ADMIN'),
            'promote-admin' => array('role'=>'ROLE_ADMIN', 'label' => 'Rendre Admin', 'newRole' => 'ROLE_ADMIN'),
            'promote-non-published' => array('role'=>'ROLE_ADMIN', 'label' => 'Peut voir non publié', 'newRole'=>'CAN_VIEW_NON_PUBLISHED'),
            'demote-user' => array('role'=>'ROLE_ADMIN', 'label' => 'Utilisateur simple', 'newRole'=>'ROLE_DEF')
            );
        $basicOpions = array(
                'attributes' => array('class' => 'btn' ),
                'routeParameters' => array(
                    'id' => $user->getId(),
                ),
            );
        foreach($menuOptions as $option => $info){
            if($securityContext->isGranted($info['role'])  && $user->hasRole($info['newRole']) === false){
                $basicOpions['label'] = $info['label'];
                $basicOpions['route'] = 'dup_user_'.strtr($option, '-','_');
                $menu->addChild($option, $basicOpions);
            }
        }
    }

    public function getExportFormats()
    {
        return array();
    }
}