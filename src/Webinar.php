<?php

namespace Muratsaglik\Zoom;

use Exception;

class Webinar extends Zoom
{
    public function registerWebinarParticipants( $webinar_id, $first_name, $last_name, $email ) {
        $postData               = array();
        $postData['first_name'] = $first_name;
        $postData['last_name']  = $last_name;
        $postData['email']      = $email;

        return $this->sendRequest( 'webinars/' . $webinar_id . '/registrants', $postData, "POST" );
    }

    public function listWebinar( $userId ) {
        $postData              = array();
        $postData['page_size'] = 300;

        return $this->sendRequest( 'users/' . $userId . '/webinars', $postData, "GET" );
    }

    public function listWebinarParticipants( $webinarId ) {
        $postData              = array();
        $postData['page_size'] = 300;

        return $this->sendRequest( 'webinars/' . $webinarId . '/registrants', $postData, "GET" );
    }
    
}
