<?php
/**
 *
 * @author justin
 * 
 * Invocation:
 * $out = new template('index_template.html');
 * $replace = array('title' => 'Claymore CRM');
 * echo $out->out($replace);
 * 
 */
class template {

    private $template_file;
    private $template;

    function __construct($template_file) {
        $this->template_file = "./template/{$GLOBALS['template']}/$template_file";
        if (file_exists($this->template_file)) {
            $this->template = file_get_contents($this->template_file);
        } else {
            die("Template file {$this->template_file} not found.");
        }
    }

    public function out($replace = array()) {
        $find = $rep = array();
        foreach (array_keys($replace) AS $r) {
            $find[] = '#\{' . $r . '\}#';
            $rep[] = $replace[$r];
        }
        
        return preg_replace($find, $rep, $this->template);
    }

}

?>
