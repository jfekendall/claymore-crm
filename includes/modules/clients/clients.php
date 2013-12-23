<?php

/**
 * Description of clients
 *
 * @author justin
 */
class clients {

    private $mode; //Intranet, B2B, B2C

    public function out() {
        return array();
    }

    /*
     * This is for an implementation of Claymore as an INTERNAL
     * ticketing system/asset management system. Employees of the company are 
     * treated as Clients
     */

    private function clientModelIntranet() {
        $this->clientModelIntranetSetup();
    }

    private function clientModelIntranetSetup() {
        $client_business_unit_table = "CREATE TABLE IF NOT EXISTS `client_business_unit` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `business_unit_name` varchar(40) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=innodb DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        $client_employees_table = "CREATE TABLE IF NOT EXISTS `client_employees` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `business_unit` int(11) NOT NULL,
            `first_name` varchar(20) NOT NULL,
            `last_name` varchar(20) DEFAULT NULL,
            `phone` varchar(15) DEFAULT NULL,
            `email` varchar(50) DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
    }

    /*
     * This is for companies that deal with other companies. 
     * Umbrella Company, Locations and Employees have been accounted for.
     */

    private function clientModelB2B() {
        $this->clientModelB2BSetup();
    }

    private function clientModelB2BSetup() {
        $client_umbrella_table = "";
        $client_locations_table = "";
        $client_contacts_table = "";
    }

    /*
     * This is for companies that deal with end users. 
     * It has accounting for minimal demographic information. Change as needed.
     */

    private function clientModelB2C() {
        $this->clientModelB2CSetup();
    }

    private function clientModelB2CSetup() {
        
        $clients_table = "CREATE TABLE IF NOT EXISTS `clients` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `first_name` varchar(20) NOT NULL,
            `last_name` varchar(20) DEFAULT NULL,
            `phone` varchar(15) DEFAULT NULL,
            `email` varchar(50) DEFAULT NULL,
            `street_1` varchar(50) DEFAULT NULL,
            `street_2` varchar(50) DEFAULT NULL,
            `city` varchar(30) DEFAULT NULL,
            `state` varchar(2) DEFAULT NULL,
            `country` varchar(50) DEFAULT NULL,
            `post_code` varchar(20) DEFAULT NULL
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        
    }

}

?>
