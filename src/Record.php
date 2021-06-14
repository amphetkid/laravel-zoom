<?php

namespace Amphetkid\Zoom;

use Exception;

class Record extends Zoom
{
    public function recordingsByMeeting( $meetingId ) {
        return $this->sendRequest( 'meetings/' . $meetingId . '/recordings', false, "GET" );
    }

    public function listRecording( $host_id, $data = array() ) {
        $postData = array();
        $from     = date( 'Y-m-d', strtotime( '-1 year', time() ) );
        $to       = date( 'Y-m-d' );

        $postData['from'] = ! empty( $data['from'] ) ? $data['from'] : $from;
        $postData['to']   = ! empty( $data['to'] ) ? $data['to'] : $to;


        return $this->sendRequest( 'users/' . $host_id . '/recordings', $postData, "GET" );
    }

}
