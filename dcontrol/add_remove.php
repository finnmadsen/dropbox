<?php
    include_once('dropboxApi.php');
    $dropbox_status = array();
    if (!isset($_REQUEST['dir']) || !isset($_REQUEST['action'])) {        
        $dropbox_status['status'] = 'ERROR: Incorrect request'; 
    }
    else {
        $cDir = '/dbox/Dropbox';
        $tok = strtok($_REQUEST['dir'], "\/");
        while ($tok !== false) {
            if ($tok > '') {
               $cDir .= '/\''.$tok.'\'';
            }
            $tok = strtok("\/");
        }
        $var = execDropbox('exclude '.$_REQUEST['action'].' '.$cDir);
// Convert to array
        $dropbox_status['status'] = '>>';
        $line = strtok($var, "\n");
        while ($line !== false) {
            $dropbox_status['status'] .= ' '.trim($line);
            $line = strtok( "\n" );
        }
    }
// Convert to Json and return
    if (is_array($dropbox_status))
      echo json_encode($dropbox_status, JSON_PRETTY_PRINT);
?>
