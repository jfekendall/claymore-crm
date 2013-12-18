<?php
/**
 * Description of navigation
 *
 * @author justin
 */
class navigation extends modules{
    
    public function nav(){
        $installed = parent::installed();
        $enabled = parent::enabled();
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
