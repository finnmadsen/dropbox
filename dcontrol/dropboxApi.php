<?php
    function getLocale($env) {
        $currentLocal = setlocale(LC_ALL, 0);
        $envp = strtok($currentLocal,'=');
        while ($envp !== false) {
            $envv = strtok(';');
            if ($envp == $env)
                return($envv);
            $envp = strtok('=');
        }
    }
    function execDropbox($command) {
       ob_start();
       passthru('cd /dbox/Dropbox; export LC_ALL='.getLocale('LC_CTYPE').'; /dbox/dropbox.py '.$command.' 2>&1');
       $res = ob_get_contents();
       ob_end_clean();
       return $res;
    }
?>
