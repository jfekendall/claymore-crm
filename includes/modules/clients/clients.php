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
        $possibilies = array("client_business_unit", "clients", "clients_accounts");
        foreach ($possibilies as $table) {
            $q = $GLOBALS['db']->query("SHOW TABLES LIKE '" . $table . "'");
            $num = $q->rowCount();
            if ($num == 1) {
                $isSetup = true;
                $hit = $table;
                break;
            }
        }
        if (!$isSetup) {
            $ra["client_setup"] = $this->setupForm();
            $ra["script"] = "$('.clientSetup').delay(250).slideToggle();";
        } else {
            $ra['client_list'] = "<h2>Clients</h2> 
                <button type='button' class='btn btn-primary clientAdd'>Add Client</button>";
            if ($hit == 'client_business_unit') {
                $ra['client_list'] .= $this->intranetClientList();
            } else if ($hit == 'clients_accounts') {
                $ra['client_list'] .= $this->b2bClientList();
                $ra['add_form'] = $this->b2bAddClient();
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
        $GLOBALS['db']->query($client_business_unit_table);
        $GLOBALS['db']->query($client_employees_table);
    }

    /*
     * This is for companies that deal with other companies. 
     * Umbrella Company, Locations and Employees have been accounted for.
     */

    private function clientModelB2BSetup() {
        $queries = array();
        $queries[0] = "CREATE TABLE IF NOT EXISTS `clients_accounts` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(50) NOT NULL,
            `password` varchar(8) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=10000";
        $queries[1] = "CREATE TABLE IF NOT EXISTS `clients_locations` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `account_id` int(11) NOT NULL,
            `business_name` varchar(60) NOT NULL,
            `is_main_office` int(1) NOT NULL DEFAULT '0',
            `phone` varchar(15) NOT NULL,
            `street_1` varchar(30) NOT NULL,
            `street_2` varchar(30),
            `city` varchar(30) NOT NULL,
            `state` varchar(2) NOT NULL,
            `post_code` varchar(10) NOT NULL,
            `country` varchar(30) DEFAULT 'United States',
            PRIMARY KEY (`id`),
            FOREIGN KEY (account_id) REFERENCES clients_accounts(id) 
            ON UPDATE CASCADE
            ON DELETE CASCADE,
            INDEX (  `business_name` ),
            INDEX (  `phone` )
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000";
        $queries[2] = "CREATE TABLE IF NOT EXISTS `clients_employees` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `account_id` int(11) NOT NULL,
            `email` varchar(50),
            `phone` varchar(15),
            `first_name` varchar(20) NOT NULL,
            `last_name` varchar(20) NOT NULL,
            `emp_type` varchar(20),
            PRIMARY KEY (`id`),
            FOREIGN KEY (account_id) REFERENCES clients_accounts(id) 
            ON UPDATE CASCADE
            ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000";
        $queries[3] = "CREATE TABLE IF NOT EXISTS `clients_employee_locations` (
            `employee_id` int(11) NOT NULL,
            `location_id` int(11) NOT NULL,
            FOREIGN KEY (employee_id) REFERENCES clients_employees(id) 
            ON UPDATE CASCADE
            ON DELETE CASCADE,
            FOREIGN KEY (location_id) REFERENCES clients_locations(id) 
            ON UPDATE CASCADE
            ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1";
        try {
            $one = $GLOBALS['db']->prepare($queries[0]);
            $one->execute();
            $two = $GLOBALS['db']->prepare($queries[1]);
            $two->execute();
            $three = $GLOBALS['db']->prepare($queries[2]);
            $three->execute();
            $four = $GLOBALS['db']->prepare($queries[3]);
            $four->execute();
            $five = $GLOBALS['db']->prepare($queries[4]);
            $five->execute();
        } catch (PDOException $ex) {
            $GLOBALS['db']->exec("DROP TABLE clients_employee_locations");
            $GLOBALS['db']->exec("DROP TABLE clients_employees");
            $GLOBALS['db']->exec("DROP TABLE clients_locations");
            $GLOBALS['db']->exec("DROP TABLE clients_accounts");
            echo $ex->getMessage() . "<br>";
            die();
        }
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
        $GLOBALS['db']->query($clients_table);
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
        if (!empty($_GET['orderby'])) {
            if ($_GET['desc']) {
                $desc = "DESC";
            }
            $orderby = " ORDER BY " . mysqli_escape_string($GLOBALS['db'], $_GET['orderby']) . " $desc ";
        }
        $clients = $GLOBALS['db']->query($GLOBALS['db'], "SELECT * FROM 
            client_employees, client_business_unit 
        WHERE 
            business_unit=client_business_unit.id 
        $orderby");

        $rs = "<table class='table table-striped'>";
        $colnames = array('first_name', 'last_name', 'business_unit_name', 'phone');
        $as = array('First Name', 'Last Name', 'Business Unit', 'Phone');
        $head = new sort_on('clients', '0', $colnames, $as, $_GET['orderby']);
        $rs .= $head->out();
        foreach ($clients AS $client) {
            $rs .= "<tr>
                <td>{$client['first_name']}</td>
                <td>{$client['last_name']}</td>
                <td>{$client['business_unit_name']}</td>
                <td>{$client['phone']}</td>
                </tr>";
        }
        $rs .= "
        </table>";
        return $rs;
    }

    private function b2bClientList() {
        if (!empty($_GET['orderby'])) {
            if ($_GET['desc']) {
                $desc = "DESC";
            }
            $orderby = " ORDER BY " . mysqli_escape_string($GLOBALS['db'], $_GET['orderby']) . " $desc ";
        }
        $clients = $GLOBALS['db']->query("SELECT * FROM 
            clients_accounts, clients_locations
        WHERE 
            clients_accounts.id = clients_locations.account_id
        AND 
            is_main_office = 1
        $orderby");

        $rs = "<table class='table table-striped'>";
        $colnames = array('account_id', 'business_name', 'phone', 'email');
        $as = array('Account #', 'Business Name', 'Phone', 'Email');
        $head = new sort_on('clients', '0', $colnames, $as, $_GET['orderby']);
        $rs .= $head->out();
        foreach ($clients AS $client) {
            $rs .= "<tr>
                <td>{$client['account_id']}</td>
                <td>{$client['business_name']}</td>
                <td>{$client['phone']}</td>
                <td>{$client['email']}</td>
                </tr>";
        }
        $rs .= "
        </table>";
        return $rs;
    }

    private function b2bAddClient() {
        $password = substr(md5(rand(0, 100000)), 0, 7);
        $elements = new formElements();
        $rs = "
            <h2>Add Primary Location</h2>
            <div class='client_add_form row'>
                <div class='col-xs-12 col-lg-4 col-md-4 col-sm-12'>
                    <input type='hidden' name='is_main_office' value='1'>
                    <label class='business_name'>Company Name<br><input type='text' required placeholder='Company Name' name='business_name'></label>
                    <label class='email'>Email Address<br><input type='email' required placeholder='someone@domain.com' name='email'></label>        
                    <label class='phone'>Location Phone<br><input type='tel' required placeholder='x-xxx-xxx-xxxx' name='phone'></label>        
                    <input type='hidden' name='password' value='$password'>
                    
                    <div class='clearFix'></div>
                </div>
                <div class='col-xs-12 col-lg-5 col-md-5 col-sm-12'>
                    ".$elements->usStyleAddress('canada')."
                    <div class='clearFix'></div>
                </div>
                <button type='button' class='btn btn-primary addNewClient'>Add Client</button>
                    
            </div>";
        return $rs;
    }

}

?>
