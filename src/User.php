<?php

namespace Muratsaglik\Zoom;

use Exception;

class User extends Zoom
{

    public function listUsers( $page = 1 )
    {
        $listUsersArray = array();
        $listUsersArray['page_size']   = 300;
        $listUsersArray['page_number'] = $page;
        $listUsersArray = $listUsersArray;

        return $this->sendRequest( 'users', $listUsersArray, "GET" );
    }

    public function createAUser( $postedData = array() )
    {
        $createAUserArray              = array();
        $createAUserArray['action']    = $postedData['action'];
        $createAUserArray['user_info'] = array(
            'email'      => $postedData['email'],
            'type'       => $postedData['type'],
            'first_name' => $postedData['first_name'],
            'last_name'  => $postedData['last_name']
        );

        return $this->sendRequest( 'users', $createAUserArray, "POST" );
    }

    public function getUserInfo($user_id)
    {
        $getUserInfoArray = array();
        $getUserInfoArray = $getUserInfoArray;

        return $this->sendRequest( 'users/' . $user_id, $getUserInfoArray );
    }

    public function deleteAUser($userid)
    {
        return $this->sendRequest( 'users/' . $userid, false, "DELETE" );
    }

}
