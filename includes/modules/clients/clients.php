<?php

/**
 * Description of clients
 *
 * @author justin
 */
class clients {

    private $mode; //Intranet, B2B, B2C

    public function out() {
        $ra = array();
        $isSetup = false;
        $hit = '';
        $db_flavor = "{$GLOBALS['db_flavor']}_query";
        $num_rows = "{$GLOBALS['db_flavor']}_num_rows";
        $possibilies = array("client_business_unit", "clients");
        foreach ($possibilies as $table) {
            $num = $db_flavor($GLOBALS['db'], "SHOW TABLES LIKE '" . $table . "'");
            if ($num_rows($num) == 1) {
                $isSetup = true;
                $hit = $table;
                break;
            }
        }
        if (!$isSetup) {
            $ra["client_setup"] = $this->setupForm();
            $ra["script"] = "$('.clientSetup').delay(250).slideToggle();";
        } else {
            if ($hit == 'client_business_unit') {
                $ra['client_list'] = $this->intranetClientList();
            }
            $ra["script"] = "$('.clientList').delay(250).slideToggle();";
        }
        return $ra;
    }

    /*
     * This is for an implementation of Claymore as an INTERNAL
     * ticketing system/asset management system. Employees of the company are 
     * treated as Clients
     */

    private function clientModelIntranetSetup() {
        $db_flavor = "{$GLOBALS['db_flavor']}_query";
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
        $db_flavor($GLOBALS['db'], "$client_business_unit_table");
        $db_flavor($GLOBALS['db'], "$client_employees_table");
    }

    /*
     * This is for companies that deal with other companies. 
     * Umbrella Company, Locations and Employees have been accounted for.
     */

    private function clientModelB2BSetup() {
        $client_umbrella_table = "";
        $client_locations_table = "";
        $client_contacts_table = "";
    }

    /*
     * This is for companies that deal with end users. 
     * It has accounting for minimal demographic information. Change as needed.
     */

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

    private function setupForm() {
        if (isset($_POST['setupAs'])) {
            if ($_POST['setupAs'] == "intranet") {
                $this->clientModelIntranetSetup();
            } else if ($_POST['setupAs'] == "B2B") {
                $this->clientModelB2BSetup();
            } else if ($_POST['setupAs'] == "B2C") {
                $this->clientModelB2CSetup();
            }
            $rs = "<h2>Success!</h2>
                <button type='button' class='btn btn-primary' onclick='location.reload();'>Click here to continue</button>";
        } else {
            $rs = "<h2>It seems you haven't set-up Client Management yet.</h2>
            <p>Answer this question to continue: Which statement is the most true?</p>
            <form action='{$GLOBALS['base_url']}/clients' method='POST'>
                <p><input type='radio' name='setupAs' value='intranet' required> I want to use this to support the company from within (Intranet). My \"Clients\" are actually workers within the same company as I work.</p>
                <p><input type='radio' name='setupAs' value='B2B' required> I want to use this to manage my company's interactions with other companies. The clients are other companies with possibly multiple locations with possibly multiple employees.</p>
                <p><input type='radio' name='setupAs' value='B2C' required> I want to use this to manage my company's interactions end-users. The clients are individuals who bought or will buy a product or service from my company.</p>
                <input type='submit' value='Configure Clients' class='btn btn-primary'>
            </form>";
        }
        return $rs;
    }

    private function intranetClientList() {
        
        $clients = mysqli_query($GLOBALS['db'], "SELECT * FROM client_employees, client_business_unit WHERE business_unit=client_business_unit.id ORDER BY client_employees.id") or die(mysqli_error($GLOBALS['db']));
        
        $rs = "<table class='table table-striped'>";
        
        while ($client = mysqli_fetch_assoc($clients)) {
            $rs .= "<tr><td>Wiener</td></tr>";
        }
        $rs .= "
        </table>";
        return $rs;
    }

}
?>
