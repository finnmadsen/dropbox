<?php
    $mesg = ['deflt' => [
              'general'  => [
                'tab'    => 'General information',    
                'title1' => 'General Status',    
                'title2' => 'Synchronization status',
                'col1'   => 'Folder',
                'col2'   => 'Status'
                           ],  
              'filter'  => [
                'tab'   => 'Filter out folders'
                           ]                
               ],            
            'sv_SE.UTF-8' => [
              'general' => [
                'tab'    => 'Generell information',    
                'title1' => 'Generell uppdateringsstatus',    
                'title2' => 'Synkronisering nivå 1',
                'col1'   => 'Mapp',
                'col2'   => 'Status'
                           ],  
              'filter'  => [
                'tab'   => 'Undanta mappar från synkronisering'
                           ]  
               ]
            ];
    function getMesg() {
        global $mesg;
        $lang = getLocale('LC_CTYPE');        
        if (isset($mesg[$lang]))
            return $mesg[$lang];
        else
            return $mesg['deflt'];    
    }         
?> 
