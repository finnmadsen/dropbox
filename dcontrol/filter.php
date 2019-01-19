<?php
    include_once('dropboxApi.php');
    include_once('lang/mesg.php');

    function listDir($dir) {
	    $node = array();
	    $files = scandir($dir);
	    if (is_array($files)) {
		    foreach ($files as $key => $value) {
			    if (in_array($value,array(".","..",".dropbox.cache",".dropbox")) || 
                                !is_dir($dir.DIRECTORY_SEPARATOR.$value)) {continue;}
                $key_b64 = base64_encode(strtolower($value));
			    $node['nodes'][$key_b64] = listDir($dir.DIRECTORY_SEPARATOR.$value);
	            $node['nodes'][$key_b64]['name'] = $value;
	            $node['nodes'][$key_b64]['include'] = 'Y';
		    }
	    }
	    return $node;		
    }
    $mesg = getMesg();

    // Find all folders on computer
    $res_arr = listDir('/dbox/Dropbox');
    $res_arr['name'] = '/dbox/Dropbox';
    $res_arr['include'] = 'Y';

    // Find folders marked for exclusion
    $var = execDropbox('exclude');
    $line = strtok($var, "\n");
    $excl_dir = array();

    // Add excluded folders to list
    while ($line !== false) {
        if (trim($line) !== 'Excluded:') {
	    $excl_dir[trim($line)] = 'Y';
        }
        $line = strtok( "\n" );
    }
    foreach ($excl_dir as $key => $value) {
	    $tok = strtok($key, "\/");
	    $var = &$res_arr;
	    while ($tok !== false) {
	        if (!in_array($tok,array('.','..'))) {
                //echo 'Excl:'.strtolower($tok).'<br/>';                
	            $tok_64 = base64_encode($tok);
		        if (!isset($var['nodes'][$tok_64])) {
		            $var['nodes'][$tok_64]['include'] = 'N';
		            $var['nodes'][$tok_64]['name'] = $tok;
                }
		        $var = &$var['nodes'][$tok_64];
	        }
	        $tok = strtok("\/");
	    }
	    if (isset($var['include']))
		    $var['include'] = 'N';	
    }
    
    // Set caption for filter      
    $res_arr['mesg']['title'] = $mesg['filter']['tab'];

    // Convert to Json and return
    $res_json = '';
    if (is_array($res_arr)) {
      echo json_encode($res_arr, JSON_PRETTY_PRINT);
    //  echo '<pre>'.json_encode($res_arr, JSON_PRETTY_PRINT).'</pre>';
    }
?>
