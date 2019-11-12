<?php
namespace App\Helpers;
class Courts {
    public static function getCourtName($court){
        if($court == 'sc') {
            $forum = 'Supreme Court';
        } elseif ($court == 'hc') {
            $forum = 'High Court';
        } elseif ($court == 'dc') {
            $forum = 'District Courts';
        } elseif ($court == 'cf') {
            $forum = 'Consumer Forums';
        } elseif ($court == 'tribunals') {
            $forum = 'Tribunals';
        } elseif ($court == 'cn'){
            $forum = 'CNR Number';
        } elseif ($court == 'cc'){
            $forum = 'Custom Courts';
        } elseif ($court == 'other'){
            $forum = 'Other Options';
        }
        return $forum;
    }
}

?>
