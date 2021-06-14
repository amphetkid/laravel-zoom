<?php

namespace Amphetkid\Zoom;

use Exception;

class Report extends Zoom
{
    public function getDailyReport( $month, $year ) {
        $getDailyReportArray          = array();
        $getDailyReportArray['year']  = $year;
        $getDailyReportArray['month'] = $month;

        return $this->sendRequest( 'report/daily', $getDailyReportArray, "GET" );
    }

    public function getAccountReport( $zoom_account_from, $zoom_account_to ) {
        $getAccountReportArray              = array();
        $getAccountReportArray['from']      = $zoom_account_from;
        $getAccountReportArray['to']        = $zoom_account_to;
        $getAccountReportArray['page_size'] = 300;

        return $this->sendRequest( 'report/users', $getAccountReportArray, "GET" );
    }
    
}
