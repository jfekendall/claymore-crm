<?php
/**
 * Description of clients
 *
 * @author justin
 */
class clients {
    private $mode; //Intranet, B2B, B2C
    
    /*
     * This is for an implementation of Claymore as an INTERNAL
     * ticketing system/asset management system
     */
    private function clientModelIntranet(){
        $this->clientModelIntranetSetup();
        
    }
    
    private function clientModelIntranetSetup(){
        
    }
    
    /*
     * This is for companies that deal with other companies. 
     * Umbrella Company, Locations and Employees have been accounted for.
     */
    private function clientModelB2B(){
        $this->clientModelB2BSetup();
        
    }
    
    private function clientModelB2BSetup(){
        
    }
    
    /*
     * This is for companies that deal with end users. 
     * It has accounting for minimal demographic information. Change as needed.
     */
    private function clientModelB2C(){
        $this->clientModelB2CSetup();
        
    }
    
    private function clientModelB2CSetup(){
        
    }
}

?>
