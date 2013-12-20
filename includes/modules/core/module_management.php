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
        foreach (parent::installed() AS $ins) {
            $ia[$ins] = "$ins";
            $counter++;
        }

        $enabled = parent::enabled();
        foreach (array_keys($enabled) AS $en) {
            $ea[$enabled[$en]['dir']][$counter] = $en;
            unset($ia[$enabled[$en]['dir']]);
            $counter++;
        }
        $counter = 0;
        foreach (array_keys($ea) AS $en) {
            $this->outArray[$counter][0] = $en; //Module Name
            $this->outArray[$counter][1] = 1; //Is enabled
            foreach ($ea[$en] AS $sub) {
                $this->outArray[$counter][2][] = $sub;
                $name = current(explode('.', $sub));
                
                if (file_exists("{$_SERVER['DOCUMENT_ROOT']}/template/{$GLOBALS['template']}/{$name}_template.html")) {
                    $this->outArray[$counter][3][] = 1;
                } else {
                    $this->outArray[$counter][3][] = 0;
                }
            }
            asort($this->outArray[$counter][2]);
            //Determine whether it's removable or not.
            if ($en == 'core') {
                $this->outArray[$counter][4] = 0;
            } else {
                $this->outArray[$counter][4] = 1;
            }

            $counter++;
        }

        foreach (array_keys($ia) AS $dis) {
            $this->outArray[$counter][0] = $dis; //Module Name
            $this->outArray[$counter][1] = 0; //Is disabled
            $this->outArray[$counter][4] = 1;
            $counter++;
        }
        $this->formatForList();
    }

    private function formatForList() {
        $rs = '';
        foreach ($this->outArray AS $row) {
            $rs .= "<tr>
                <th class='mm_module_name'>" . ucwords($row[0]) . "</th>
                <td></td>
                <td  class='mm_has_template'>
                    <input type='checkbox' ".($row[1] ? 'checked' : '')." ".($row[4] == 1 ? '' : 'disabled')." class='enableModule' id='{$row[0]}'>
                </td>
                <td></td>
            </tr>";
            if (isset($row[2])) {
                foreach (array_keys($row[2]) AS $sub) {
                    $rs .= "<tr>
                    <td class='mm_sub_modules'>" .
                            ucwords(str_replace('_', ' ', current(explode('.', $row[2][$sub])))) . "
                    </td>
                    <td class='mm_sub_modules mm_has_template'>";
                    if ($row[3][$sub]) {
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
