<?php

/**
 * Description of setup
 *
 * @author justin
 */
class setup {

    private $config = array();

    function __construct($CONFIG) {
        $this->config = $CONFIG;
    }

    public function stuff($setupArray) {

        if (isset($_POST['db_flavor'])) {
            $this->config = array_merge($this->config, $_POST);
            $this->genConfig();
        } else {
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
                    if ($check == 'Mysqli enabled') {
                        $rs['stuff'] .= "To enable this required feature, be sure to install the latest version of php5-mysqli from your distributions package repository and restart Apache.";
                    } else if ($check == 'mod_rewrite enabled') {
                        $rs['stuff'] .= "To enable this required feature, open a terminal as root and type \"a2enmod rewrite\" without quotes. Then restart Apache.";
                    } else if ($check == "Config File Writable") {
                        $rs['stuff'] .= "It is important to make the config file writable in order to continue. It is usually a permissions issue.";
                    }
                    $rs['stuff'] .= "</div></td>
                    </tr>
                </tr>";
                }
                $rs['stuff'] .= "</td>";
                $rs['stuff'] .= "</tr>";
            }
            if ($overall == true) {
                return $this->configureThings();
            }
            return $rs;
        }
    }

    private function configureThings() {
        $rs['stuff'] = "
            <form action='.' method='POST'>
            <input type='hidden' name='template' value='default'>
        <tr>
            <td colspan='2'><h2>Server Variables</h2></td>
        </tr>
        <tr>
            <td>Root URL</td>
            <td><input type='text' name='base_url' value='{$this->config['base_url']}' required></td>
        </tr>
        <tr>
            <td>Application Name</td>
            <td><input type='text' name='title' value='Claymore CRM' required></td>
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
            <td><input type='password' name='db_password' placeholder='password'></td>
        </tr>
        <tr>
            <td>DB Name</td>
            <td><input type='text' name='db_database' value='claymore' required></td>
        </tr>
        <tr>
            <td>Table Prefix (Optional)</td>
            <td><input type='text'  name='db_table_prefix' value='' placeholder='claymore_'></td>
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
            <td><select name='auth_password_hash_algo'>";
        foreach (hash_algos() AS $algo) {
            $rs['stuff'] .= "<option value='$algo' " . ($algo == 'sha512' ? 'selected' : '') . ">$algo</option>";
        }
        $rs['stuff'] .= "</select></td>
        </tr>
        <tr>
            <td>Inactivity Timeout (in seconds)</td>
            <td><input type='number' name='auth_expire_time' value='3600'></td>
        </tr>
        <tr>
            <td>LDAP Host (Optional)</td>
            <td><input type='text' value='' name='ldap_host' placeholder='optional'></td>
        </tr>
        <tr>
            <td>LDAP Port (Optional)</td>
            <td><input type='number' value='' name='ldap_port' placeholder='optional'></td>
        </tr>
        <tr>
            <td colspan='2'><h2>Mail Options</h2></td>
        </tr>
        <tr>
            <td class=''>SMTP Hostname</td>
            <td><input type='text' name='smtp_server' placeholder='optional'></td>
        </tr>
        <tr>
            <td class=''>SMTP Port</td>
            <td><input type='text' name='smtp_port' placeholder='optional'></td>
        </tr>
        <tr>
            <td>Default SMTP Username</td>
            <td><input type='text' name='smtp_default_sender' placeholder='optional'></td>
        </tr>
        <tr>
            <td>Default SMTP Password</td>
            <td><input type='password'  name='smtp_default_password' placeholder='optional'></td>
        </tr>
        <tr>
            <td colspan='2' class='setup-td'><button class='btn btn-primary' type='submit'>Generate Config File</button></td>
        </tr>
        </form>
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

    private function genConfig() {

        $config_file_contents = "<?php";
        foreach (array_keys($this->config) AS $config) {
            $config_file_contents .= "\n\$CONFIG['$config'] = '{$this->config[$config]}';\n";
        }
        $config_file_contents .= "\$replace = array(\n
            'title' => '{$this->config['title']}',\n
            'template' => 'default',\n
            'copyright' => 'Proudly Powered by Claymore CRM',\n
            'base_url' => '{$this->config['base_url']}'\n
        );
        \$CONFIG['db'] = new PDO(\"mysql:host={$this->config['db_hostname']};dbname={$this->config['db_database']};charset=utf8\", '{$this->config['db_username']}', '{$this->config['db_password']}');\n
        \$CONFIG['db']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\n
        \$CONFIG['db']->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        \n";
        file_put_contents("{$this->config['base_dir']}config.php", $config_file_contents);
        $this->dbSetup();
        echo "<script>
                document.location = '{$this->config['base_url']}'
            </script>";
    }

    private function dbSetup() {
        $db = new PDO("mysql:host={$this->config['db_hostname']};dbname={$this->config['db_database']};charset=utf8", $this->config['db_username'], $this->config['db_password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = file_get_contents($this->config['base_dir'] . "setup/claymore.sql");
        $sql = str_replace(array('users', 'modules'), array("{$this->config['db_table_prefix']}users", "{$this->config['db_table_prefix']}modules"), $sql);
        foreach (explode(';', $sql) AS $s) {
            if (!empty(trim($s))) {
                $db->query($s);
            }
        }
    }

    function checklist() {
        if (parent::config_writable()) {
            return true;
        }
        return false;
    }

}

?>
