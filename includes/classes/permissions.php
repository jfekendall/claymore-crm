<?php
/**
 * Description of permissions
 *
 * @author justin
 */
class permissions {
    private $whereami;
    private $whoami;
    function __construct(){
        $this->whereami = $GLOBALS['location'];
        $this->setup();    
        if(!$this->allowed_to_be_here()){
            echo "You aren't supposed to be here.";
            die();
        }
    }
    
    private function setup(){
        //echo $this->whereami;
        //TODO: Database Stuff
    }
    
    private function allowed_to_be_here(){
        return false;
    }
}

?>
