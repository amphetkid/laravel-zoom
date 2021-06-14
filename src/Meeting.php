<?php

namespace Amphetkid\Zoom;

use Exception;

class Meeting extends Zoom
{
    public function listMeetings( $host_id ) {
        $listMeetingsArray              = array();
        $listMeetingsArray['page_size'] = 300;

        return $this->sendRequest(
            'users/'.$host_id.'/meetings', $listMeetingsArray,
            "GET"
        );
    }

    public function createMeeting( $data = array() ) {
        $post_time  = $data['start_date']." ".$data['start_time'];
        $start_time = gmdate( "Y-m-d\TH:i:s", strtotime( $post_time ) );

        $createMeetingArray = array();

        if (!empty( $data['alternative_host_ids'])) {
            if (count($data['alternative_host_ids']) > 1) {
                $alternative_host_ids = implode(",", $data['alternative_host_ids']);
            } else {
                $alternative_host_ids = $data['alternative_host_ids'][0];
            }
        }

        $createMeetingArray['topic']      = $data['meetingTopic'];
        $createMeetingArray['agenda']     = !empty($data['agenda']) ? $data['agenda'] : "";
        $createMeetingArray['type']       = !empty($data['type']) ? $data['type'] : 2; //Scheduled
        $createMeetingArray['start_time'] = $start_time;
        $createMeetingArray['timezone']   = $data['timezone'];
        $createMeetingArray['password']   = !empty($data['password'] ) ? $data['password'] : "";
        $createMeetingArray['duration']   = !empty($data['duration'] ) ? $data['duration'] : 60;
        if(!empty($data['recurrence'])){
            $createMeetingArray['recurrence'] = array(
                'type' =>   !empty($data['recurrence_type'] ) ? $data['recurrence_type'] : 1,
                'repeat_interval' =>   !empty($data['repeat_interval'] ) ? $data['repeat_interval'] : 1,
                'weekly_days' =>   !empty($data['recurrence_weekly_days'] ) ? $data['recurrence_weekly_days'] : "",
                'monthly_day' =>   !empty($data['recurrence_monthly_day'] ) ? $data['recurrence_monthly_day'] : "",
                'monthly_week' =>   !empty($data['recurrence_monthly_week'] ) ? $data['recurrence_monthly_week'] : "",
                'monthly_week_day' =>   !empty($data['recurrence_monthly_week_day'] ) ? $data['recurrence_monthly_week_day'] : "",
                'end_times' =>   !empty($data['recurrence_end_times'] ) ? $data['recurrence_end_times'] : "",
                'end_date_time' =>   !empty($data['recurrence_end_date_time'] ) ? $data['recurrence_end_date_time'] : "",
            );
        }
        $createMeetingArray['settings']   = array(
            'join_before_host'  => !empty($data['join_before_host'] ) ? true : false,
            'host_video'        => !empty($data['option_host_video'] ) ? true : false,
            'participant_video' => !empty($data['option_participants_video'] ) ? true : false,
            'mute_upon_entry'   => !empty($data['option_mute_participants'] ) ? true : false,
            'enforce_login'     => !empty($data['option_enforce_login'] ) ? true : false,
            'auto_recording'    => !empty($data['option_auto_recording'] ) ? $data['option_auto_recording'] : "none",
            'alternative_hosts' => isset( $alternative_host_ids ) ? $alternative_host_ids : "",
            'enforce_login'     => !empty($data['enforce_login'] ) ? true : false,
            'waiting_room'      => !empty($data['option_waiting_room'] ) ? true : false,
            'close_registration'=> !empty($data['option_close_registration'] ) ? true : false,
            'jbh_time'          => !empty($data['jbh_time']) ? 10:5,
            'approval_type'     => !empty($data['approval_type']) ? $data['approval_type']:0,

        );

        if ( !empty($createMeetingArray ) ) {
            return $this->sendRequest( 'users/' . $data['userId'] . '/meetings', $createMeetingArray, "POST" );
        } else {
            return;
        }
    }

    public function updateMeetingInfo( $update_data = array() ) {
        $post_time  = $update_data['start_date'];
        $start_time = gmdate( "Y-m-d\TH:i:s", strtotime( $post_time ) );

        $updateMeetingInfoArray = array();

        if ( !empty($update_data['alternative_host_ids'] ) ) {
            if ( count( $update_data['alternative_host_ids'] ) > 1 ) {
                $alternative_host_ids = implode( ",", $update_data['alternative_host_ids'] );
            } else {
                $alternative_host_ids = $update_data['alternative_host_ids'][0];
            }
        }

        $updateMeetingInfoArray['topic']      = $update_data['topic'];
        $updateMeetingInfoArray['agenda']     = !empty($update_data['agenda'] ) ? $update_data['agenda'] : "";
        $updateMeetingInfoArray['type']       = !empty($update_data['type'] ) ? $update_data['type'] : 2; //Scheduled
        $updateMeetingInfoArray['start_time'] = $start_time;
        $updateMeetingInfoArray['timezone']   = $update_data['timezone'];
        $updateMeetingInfoArray['password']   = !empty($update_data['password'] ) ? $update_data['password'] : "";
        $updateMeetingInfoArray['duration']   = !empty($update_data['duration'] ) ? $update_data['duration'] : 60;
        $updateMeetingInfoArray['settings']   = array(
            'join_before_host'  => !empty($update_data['option_jbh'] ) ? true : false,
            'host_video'        => !empty($update_data['option_host_video'] ) ? true : false,
            'participant_video' => !empty($update_data['option_participants_video'] ) ? true : false,
            'mute_upon_entry'   => !empty($update_data['option_mute_participants'] ) ? true : false,
            'enforce_login'     => !empty($update_data['option_enforce_login'] ) ? true : false,
            'auto_recording'    => !empty($update_data['option_auto_recording'] ) ? $update_data['option_auto_recording'] : "none",
            'alternative_hosts' => isset( $alternative_host_ids ) ? $alternative_host_ids : ""
        );

        if ( !empty($updateMeetingInfoArray ) ) {
            return $this->sendRequest('meetings/' . $update_data['meetingId'], $updateMeetingInfoArray, "PATCH");
        } else {
            return;
        }
    }

    public function getMeetingInfo( $id )
    {
        $getMeetingInfoArray = array();

        return $this->sendRequest('meetings/' . $id, $getMeetingInfoArray, "GET");
    }

    public function deleteMeeting( $meetingId )
    {
        $deleteMeetingArray = array();

        return $this->sendRequest(
            'meetings/' . $meetingId, $deleteMeetingArray, #
            "DELETE"
        );
    }

    public function getMeetingRegistrant($meetingId)
    {
        return $this->sendRequest('meetings/'.$meetingId.'/registrants', [], "GET");
    }



    public function getPastParticipants($meetingId)
    {
        return $this->sendRequest('past_meetings/'.$meetingId.'/participants', [], "GET");
    }

    public function getPastMeetingInfo($meetingId)
    {
        return $this->sendRequest('past_meetings/'.$meetingId, [], "GET");
    }


}
