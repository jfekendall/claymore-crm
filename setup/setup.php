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
            return true;
        }
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
