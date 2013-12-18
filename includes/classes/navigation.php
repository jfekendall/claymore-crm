<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of navigation
 *
 * @author justin
 */
class navigation {
    
    public function nav(){
        require_once("modules.php");
        $mods = new modules();
        $installed = $mods->installed();
        $enabled = $mods->enabled();
        $rs = '';
        foreach($enabled as $en){
            $rs .= "<li>
                <a href='".strtolower(current(explode('.php',$en)))."'>
                    ".ucwords(str_replace('_', ' ', current(explode('.php',$en))))."
                </a>
            </li>";
        }
        return $rs;
    }
}

?>
