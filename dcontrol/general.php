<?php
    include_once('dropboxApi.php');
    include_once('lang/mesg.php');

    $dropbox_status = array();
    $dropbox_status['mesg'] = array();
    $dropbox_status['general'] = array();
    $dropbox_status['fs'] = array();

    $mesg = getMesg();
    
// Get dropbox status
    $var = execDropbox('status');
// Convert to array
    $line = strtok($var, "\n");
    $dropbox_status['mesg']['titel']   = $mesg['general']['tab'];
    $dropbox_status['mesg']['general'] = $mesg['general']['title1'];
    $dropbox_status['mesg']['level1']  = $mesg['general']['title2'];
    $dropbox_status['mesg']['col1'] = $mesg['general']['col1'];
    $dropbox_status['mesg']['col2']  = $mesg['general']['col2'];
    while ($line !== false) {
        array_push($dropbox_status['general'], trim($line));
        $line = strtok( "\n" );
    }
    
// Get dropbox file status level 1
    $var = execDropbox('filestatus /dbox/Dropbox/*');
// Convert to array
    $map = strtok($var, ":");
    while ($map !== false) {
        $mapstat = strtok( "\n" );
        array_push($dropbox_status['fs'], [$map,$mapstat] );
        $map = strtok(":");
    }

// Convert to Json and return
    if (is_array($dropbox_status))
      echo json_encode($dropbox_status, JSON_PRETTY_PRINT);
?>
