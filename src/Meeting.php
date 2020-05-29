<?php

namespace Muratsaglik\Zoom;

use Exception;

class Meeting extends Zoom
{
    public function listMeetings( $host_id ) {
        $listMeetingsArray              = array();
        $listMeetingsArray['page_size'] = 300;

        return $this->sendRequest( 'users/' . $host_id . '/meetings', $listMeetingsArray, "GET" );
    }

    public function createAMeeting( $data = array() ) {
        $post_time  = $data['start_date']." ".$data['start_time'];
        $start_time = gmdate( "Y-m-d\TH:i:s", strtotime( $post_time ) );

        $createAMeetingArray = array();

        if ( ! empty( $data['alternative_host_ids'] ) ) {
            if ( count( $data['alternative_host_ids'] ) > 1 ) {
                $alternative_host_ids = implode( ",", $data['alternative_host_ids'] );
            } else {
                $alternative_host_ids = $data['alternative_host_ids'][0];
            }
        }

        $createAMeetingArray['topic']      = $data['meetingTopic'];
        $createAMeetingArray['agenda']     = ! empty( $data['agenda'] ) ? $data['agenda'] : "";
        $createAMeetingArray['type']       = ! empty( $data['type'] ) ? $data['type'] : 2; //Scheduled
        $createAMeetingArray['start_time'] = $start_time;
        $createAMeetingArray['timezone']   = $data['timezone'];
        $createAMeetingArray['password']   = ! empty( $data['password'] ) ? $data['password'] : "";
        $createAMeetingArray['duration']   = ! empty( $data['duration'] ) ? $data['duration'] : 60;
        $createAMeetingArray['settings']   = array(
            'join_before_host'  => ! empty( $data['join_before_host'] ) ? true : false,
            'host_video'        => ! empty( $data['option_host_video'] ) ? true : false,
            'participant_video' => ! empty( $data['option_participants_video'] ) ? true : false,
            'mute_upon_entry'   => ! empty( $data['option_mute_participants'] ) ? true : false,
            'enforce_login'     => ! empty( $data['option_enforce_login'] ) ? true : false,
            'auto_recording'    => ! empty( $data['option_auto_recording'] ) ? $data['option_auto_recording'] : "none",
            'alternative_hosts' => isset( $alternative_host_ids ) ? $alternative_host_ids : ""
        );
        
        if ( ! empty( $createAMeetingArray ) ) {
            return $this->sendRequest( 'users/' . $data['userId'] . '/meetings', $createAMeetingArray, "POST" );
        } else {
            return;
        }
    }

    public function updateMeetingInfo( $update_data = array() ) {
        $post_time  = $update_data['start_date'];
        $start_time = gmdate( "Y-m-d\TH:i:s", strtotime( $post_time ) );

        $updateMeetingInfoArray = array();

        if ( ! empty( $update_data['alternative_host_ids'] ) ) {
            if ( count( $update_data['alternative_host_ids'] ) > 1 ) {
                $alternative_host_ids = implode( ",", $update_data['alternative_host_ids'] );
            } else {
                $alternative_host_ids = $update_data['alternative_host_ids'][0];
            }
        }

        $updateMeetingInfoArray['topic']      = $update_data['topic'];
        $updateMeetingInfoArray['agenda']     = ! empty( $update_data['agenda'] ) ? $update_data['agenda'] : "";
        $updateMeetingInfoArray['type']       = ! empty( $update_data['type'] ) ? $update_data['type'] : 2; //Scheduled
        $updateMeetingInfoArray['start_time'] = $start_time;
        $updateMeetingInfoArray['timezone']   = $update_data['timezone'];
        $updateMeetingInfoArray['password']   = ! empty( $update_data['password'] ) ? $update_data['password'] : "";
        $updateMeetingInfoArray['duration']   = ! empty( $update_data['duration'] ) ? $update_data['duration'] : 60;
        $updateMeetingInfoArray['settings']   = array(
            'join_before_host'  => ! empty( $update_data['option_jbh'] ) ? true : false,
            'host_video'        => ! empty( $update_data['option_host_video'] ) ? true : false,
            'participant_video' => ! empty( $update_data['option_participants_video'] ) ? true : false,
            'mute_upon_entry'   => ! empty( $update_data['option_mute_participants'] ) ? true : false,
            'enforce_login'     => ! empty( $update_data['option_enforce_login'] ) ? true : false,
            'auto_recording'    => ! empty( $update_data['option_auto_recording'] ) ? $update_data['option_auto_recording'] : "none",
            'alternative_hosts' => isset( $alternative_host_ids ) ? $alternative_host_ids : ""
        );

        if ( ! empty( $updateMeetingInfoArray ) ) {
            return $this->sendRequest( 'meetings/' . $update_data['meeting_id'], $updateMeetingInfoArray, "PATCH" );
        } else {
            return;
        }
    }

    public function getMeetingInfo( $id ) {
        $getMeetingInfoArray = array();

        return $this->sendRequest( 'meetings/' . $id, $getMeetingInfoArray, "GET" );
    }

    public function deleteAMeeting( $meeting_id ) {
        $deleteAMeetingArray = array();

        return $this->sendRequest( 'meetings/' . $meeting_id, $deleteAMeetingArray, "DELETE" );
    }

}
