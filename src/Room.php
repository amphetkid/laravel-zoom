<?php

namespace Muratsaglik\Zoom;

use Exception;

class Room extends Zoom
{

    public function listRooms()
    {
        $listMeetingsArray              = array();
        $listMeetingsArray['page_size'] = 300;

        return $this->sendRequest( 'rooms/', $listMeetingsArray, "GET" );
    }

}
