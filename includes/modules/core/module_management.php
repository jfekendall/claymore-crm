<?php

/**
 * Description of module_management
 *
 * @author justin
 */
class module_management extends modules {

    private $outArray = array();
    private $formattedOut;

    function __construct() {
        $this->modules();
    }

    public function out() {
        $out = array();
        $out['modules'] = $this->formattedOut;
        $out['header'] = 'Module Management';
        return $out;
    }

    private function modules() {
        $ia = array();
        $ea = array();
        $counter = 1;
        $enabled = parent::enabled();
        $installed = parent::installed();
        foreach (array_keys($enabled) AS $mod) {
            $this->outArray[$counter][0] = $mod; //Module Name
            $this->outArray[$counter][1] = $enabled[$mod]['enabled']; //Enabled
            $this->outArray[$counter][2] = $enabled[$mod]['feature']; //Features Array
            if ($mod == 'core') {
                $this->outArray[$counter][3] = 0; //Can Be Disabled
            } else {
                $this->outArray[$counter][3] = 1; //Can Be Disabled
            }
            $this->outArray[$counter][4] = $enabled[$mod]['mod_nav_order']; //Nav Order
            unset($installed[$mod]); //Make sure it doesn't show up twice
            $counter++;
        }

        foreach (array_keys($installed) AS $mod) {
            $this->outArray[$counter][0] = $mod; //Module Name
            $this->outArray[$counter][1] = 0; //Enhabled
            $this->outArray[$counter][2] = $installed[$mod]['feature']; //Features Array
            $this->outArray[$counter][3] = 1; //Can Be Disabled
            $counter++;
        }
        $this->formatForList();
    }

    private function formatForList() {
        extract($GLOBALS['CONFIG']);
        $rs = '';
        foreach ($this->outArray AS $row) {
            $rs .= "<tr>
                <th class='mm_module_name'>" . ucwords(str_replace('_', ' ', $row[0])) . "</th>
                <td></td>
                <td  class='mm_has_template'>
                    <input type='checkbox' " . ($row[1] ? 'checked' : '') . " " . ($row[3] == 1 ? '' : 'disabled') . " class='enableModule' id='{$row[0]}'>
                </td>
                <td class='mm_has_template'> <input type='number' class='changeNavOrder' value='" . (!empty($row[4]) ? $row[4] : '0') . "' min=0 max=100 id='{$row[0]}'></td>
                <td class='mm_has_template'>";
            if ($row[3]) {
                $rs .= "<button class='btn bnt-primary removeModule' id='{$row[0]}'>Remove</button>";
            }
            $rs .= "</td>
            </tr>";
            if (isset($row[2])) {
                foreach ($row[2] AS $sub) {
                    $name = current(explode('.', $sub));
                    $rs .= "<tr>
                    <td class='mm_sub_modules'>" .
                            ucwords(str_replace('_', ' ', $name)) . "
                    </td>
                    <td class='mm_sub_modules mm_has_template'>";
                    if (file_exists("{$base_dir}template/{$template}/{$name}_template.html")) {
                        $rs .= "<i class='glyphicon glyphicon-ok'></i>";
                    } else {
                        $rs .="<i class='glyphicon glyphicon-remove'></i>";
                    }
                    $rs .="</td>
                    </tr>";
                }
            }
        }
        $this->formattedOut = $rs;
    }

}

?>
