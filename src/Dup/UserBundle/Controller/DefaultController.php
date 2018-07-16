<?php

namespace Dup\UserBundle\Controller;

use Dup\BackboneBundle\Service\ToArray;
use Dup\UserBundle\Entity\User;
use Dup\UserBundle\Entity\UserParameter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    const DEFAULT_AVATAR = 'default.png';
    
    public function changeActionDateAction ()
    {
        $user = $this -> getUser ();
        $user -> setLastActionDate ( new \DateTime() );
        $em = $this -> getDoctrine ()
                    -> getManager ();
        $em -> persist ( $user );
        $em -> flush ();
        
        return new Response( "ok" );
    }
    
    public function updateUserAction ( Request $request )
    {
        $validPosts = [ 'avatar', 'prenoms', 'nom', 'param-chat' /*,  'email' */, 'birthdate', 'param-chrono', 'param-battle' ];
        $posts      = $request -> request -> all ();
        /** @var User $user */
        $user        = $this -> getUser ();
        $em          = $this -> get ( 'doctrine.orm.entity_manager' );
        $params      = $em -> getRepository ( 'DupUserBundle:UserParameter' ) -> findBy ( [ 'user' => $user ] );
        $paramMapped = [];
        $result = [
            'changed' => []
        ];
        foreach ( $params as $param ) {
            $title                 = (string) $param -> getTitle ();
            $paramMapped[ $title ] = $param;
        }
        foreach ( $posts as $property => $value ) {
            if ( in_array ( $property, $validPosts, true ) === false ) {
                continue;
            }
            $validValue = trim ( strip_tags ( $value ) );
            switch ( $property ) {
                case 'birthdate' :
                    $user -> setBirthdate ( \DateTime ::createFromFormat ( ToArray::DATE_FORMAT, $validValue ) );
                    break;
                case 'prenoms' :
                    $user -> setPrenoms ( $validValue );
                    break;
                case 'nom' :
                    $user -> setNom ( $validValue );
                    break;
                case 'avatar' :
                    $avatarDir      = $this -> get ( 'kernel' ) -> getRootDir () . '/../web/uploads/medias/avatars/';
                    $previousAvatar = $user -> getAvatar ();
                    if ( $previousAvatar !== self::DEFAULT_AVATAR ) {
                        unlink ( $avatarDir . $previousAvatar );
                    }
                    $filename = sha1 ( uniqid () . 'I luv u !' );
                    $filename = $this -> base64ToImage ( $validValue, $avatarDir, $filename );
                    $user -> setAvatar ( $filename );
                    $result['newAvatar'] = $filename;
                    break;
                case 'param-chrono':
                case 'param-chat':
                case 'param-battle':
                    $parts = explode ( '-', $property );
                    /** @var UserParameter $parameter */
                    $parameter = $paramMapped[ $parts[ 1 ] ];
                    $parameter -> setValue ( $validValue );
                    $em -> persist ( $parameter );
                    break;
            }
            $result['changed'][] = $property;
        }
        
        $em -> persist ( $user );
        $em -> flush ();
    
        return new Response( json_encode ( $result) );
    }
    
    private function base64ToImage ( $base64String, $directory, $filename )
    {
        $data = explode ( ',', $base64String );
        $image = base64_decode ( $data[ 1 ] );
        $f = finfo_open();
        $mime = finfo_buffer( $f, $image, FILEINFO_MIME_TYPE);
        $extension = $this->getExtensionFromMime( $mime);
        $basename = $filename . '.' . $extension;
        $file = fopen ( $directory . $basename, "wb" );
        fwrite ( $file, $image );
        fclose ( $file );
        return $basename;
    }
    
    private function getExtensionFromMime($mimeType){
        $exploded = explode( '/', $mimeType);
        return $exploded[1];
    }
}
