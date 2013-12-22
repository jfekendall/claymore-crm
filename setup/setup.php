<?php

/**
 * Description of setup
 *
 * @author justin
 */
class setup {

    public function stuff($setupArray) {
        $overall = true;
        $setupArray = $setupArray->deps();
        $rs['stuff'] = '';
        foreach (array_keys($setupArray) AS $check) {
            $rs['stuff'] .= "<tr><td class='setup-td'>$check</td>
                <td class='setup-td'>";
            if ($setupArray[$check]) {
                $rs['stuff'] .= "<i class='glyphicon glyphicon-ok'></i>";
            } else {
                $overall = false;
                $rs['stuff'] .= "<i class='glyphicon glyphicon-remove'></i></td></tr>
                    <tr>
                        <td colspan=2><div class='alert alert-info'>";
                        if($check == 'Mysqli enabled'){
                            $rs['stuff'] .=  "To enable this required feature, be sure to install the latest version of php5-mysqli from your distributions package repository and restart Apache.";
                        }else if($check == 'mod_rewrite enabled'){
                            $rs['stuff'] .=  "To enable this required feature, open a terminal as root and type \"a2enmod rewrite\" without quotes. Then restart Apache.";
                        }else if($check  == "Config File Writable"){
                            $rs['stuff'] .=  "It is important to make the config file writable in order to continue. It is usually a permissions issue.";
                        }
                $rs['stuff'] .= "</div></td>
                    </tr>
                </tr>";
               
            }
             $rs['stuff'] .= "</td>";
            $rs['stuff'] .= "</tr>";
        }
        if($overall == true){
            return $this->configureThings();
        }
        return $rs;
    }

    private function configureThings(){
        $rs['stuff'] = "
        <tr>
            <td colspan='2'><h2>Server Variables</h2></td>
        </tr>
        <tr>
            <td>Root URL</td>
            <td><input type='text' value='{$GLOBALS['base_url']}' required></td>
        </tr>
        <tr>
            <td>Application Name</td>
            <td><input type='text' value='Claymore CRM' required></td>
        </tr>
            <tr>
            <td colspan='2'><h2>Database</h2></td>
        </tr>
        <tr>
            <td>DB Flavor</td>
            <td><select name='db_flavor'>
                <option value='mysqli'>MySQL</option>
                <option value='mssql'>MSSQL</option>
            </select></td>
        </tr>
        <tr>
            <td class=''>DB Hostname</td>
            <td><input type='text' name='db_hostname' placeholder='localhost' required></td>
        </tr>
        <tr>
            <td class=''>DB Username</td>
            <td><input type='text' name='db_username' placeholder='root' required></td>
        </tr>
        <tr>
            <td>DB Password</td>
            <td><input type='password' name='db_password' placeholder='password' required></td>
        </tr>
        <tr>
            <td>DB Name</td>
            <td><input type='text' name='db_database' value='claymore' required></td>
        </tr>
        <tr>
            <td>Table Prefix (Optional)</td>
            <td><input type='text' value='' placeholder='claymore_'></td>
        </tr>
        <tr>
            <td colspan='2'><button type='button' class='btn btn-primary dbtest'>Test This Configuration</button></td>
        </tr>
        <tr>
            <td colspan='2'><h2>User Authentication</h2></td>
        </tr>
        <tr>
            <td>Authentication Source</td>
            <td><select name='auth_method'>
                <option value='local'>Local</option>
                <option value='ldap'>LDAP</option>
            </select></td>
        </tr>
        <tr>
            <td>Password Hash Algorithm (For local login)</td>
            <td><select name='auth_method'>";
                foreach(hash_algos() AS $algo){
                    $rs['stuff'] .= "<option value='$algo' ".($algo=='sha512' ? 'selected' : '').">$algo</option>";
                }
            $rs['stuff'] .= "</select></td>
        </tr>
        <tr>
            <td>Inactivity Timeout (in seconds)</td>
            <td><input type='number' name='auth_expire_time' value='3600'></td>
        </tr>
        <tr>
            <td>LDAP Host (Optional)</td>
            <td><input type='text' value='' placeholder='optional'></td>
        </tr>
        <tr>
            <td>LDAP Port (Optional)</td>
            <td><input type='number' value='' placeholder='optional'></td>
        </tr>
        <tr>
            <td colspan='2'><h2>Mail Options</h2></td>
        </tr>
        <tr>
            <td class=''>SMTP Hostname</td>
            <td><input type='text' placeholder='optional'></td>
        </tr>
        <tr>
            <td class=''>SMTP Port</td>
            <td><input type='text' placeholder='optional'></td>
        </tr>
        <tr>
            <td>Default SMTP Username</td>
            <td><input type='text' placeholder='optional'></td>
        </tr>
        <tr>
            <td>Default SMTP Password</td>
            <td><input type='password' placeholder='optional'></td>
        </tr>
        <script>
            $('.dbtest').click(function(){
                var db_hostname= $('input[name=db_hostname]').val();
                var db_username= $('input[name=db_username]').val();
                var db_password= $('input[name=db_password]').val();
                var db_database= $('input[name=db_database]').val();
                var result = $.ajax({
                    url : './setup/tests.php?type=db&db_hostname='+db_hostname+'&db_username='+db_username+'&db_password='+db_password+'&db_database='+db_database,
                    async: false
                }).responseText;
                alert(result);
            });
        </script>";
            return $rs;
    }
    
    function checklist() {
        if (parent::config_writable()) {
            return true;
        }
        return false;
    }

}

?>
