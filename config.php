<?php
    $config = Config::singleton();

    //Folders' Direction
    $config->set('controllersFolder', 'Controllers/');
    $config->set('modelsFolder', 'Models/');
    $config->set('xmlFolder', 'Models/xml/');
    $config->set('wsFolder', 'Models/services/');
    $config->set('viewsFolder', 'Views/');
    $config->set('templatesFolder', 'Templates/');
    
    $config->set('Template', 'default.php');
    
    //Vars URL
    $config->set('BaseUrl', 'http://guayacan.uninorte.edu.co/obci/');

    //Data Base Configuration
    $config->set('driver', 'mysql');
    $config->set('dbhost', 'localhost');
    $config->set('dbname', 'obci');
    $config->set('dbuser', 'root');
    $config->set('dbpass', 'KEY');
?>
