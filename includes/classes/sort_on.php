<?php
class sort_on {

    public $section;
    public $action;
    public $colnames;
    public $subaction;
    public $orderby;
    public $desc;
    public $base_url;
    public $return;
    
    public function __construct($section, $action, $colnames, $as, $orderby = 'id') {
        if ($_SERVER['SERVER_PORT'] == 80) {
            $this->base_url = 'http://' . $_SERVER['HTTP_HOST'];
        } else {
            $this->base_url = 'https://' . $_SERVER['HTTP_HOST'];
        }
        $this->action = $action;
        $this->section = $section;
        $rs = "<tr>";
        for($j=0; $j < sizeof($as); $j++){
            if($orderby == $colnames[$j] && $_GET['desc']==0){
                $desc = 1;
            }else{
                $desc = 0;
            }
            
            if($orderby == $colnames[$j] && $desc == 0){
                $icon = "<i class='glyphicon glyphicon-chevron-down'></i>";
            }else if($orderby == $colnames[$j] && $desc == 1){
                $icon = "<i class='glyphicon glyphicon-chevron-up'></i>";
            }else{
                $icon = '';
            }
            $rs .= "<th style='text-align:center;'>
                <a href='$this->base_url/$this->section/$this->action".(isset($_GET['subaction']) ? "/".$_GET['subaction'] : '')."/sort/{$colnames[$j]}/$desc'>
                {$as[$j]}{$icon}
                </a>
            </th>\n";
        }
        $rs .= "</tr>";
        $this->return = $rs;
    }
    
    public function out(){
        return $this->return;
    }
}

?>
