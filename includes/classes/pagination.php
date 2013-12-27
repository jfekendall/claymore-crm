<?php

class pagination {

    public $section;

    function display_pagination() {
        if (!$order) {
            $order = 1;
        }
        if ($asc != '') {
            $asc = "/asc";
        }
        $range = 5;
        echo '
    <div class="pagination">
      <ul>
        <li';

        if ($current_page == 1) {
            echo " class='disabled'><a href='#'";
        } else {
            echo "><a href='$base_url/$section/$filter/" . $_GET['subaction'] . "/sort/{$_GET['sorton']}/{$_GET['desc']}/" . ($current_page - 1) . "'";
        }
        echo '>Prev</a></li>';

        for ($i = 0; $i < $number_of_pages; $i++) {
            if (((($i + 1 <= $current_page + $range) && ($i + 1 >= $current_page - $range + 1)) || (($i + 1 <= $range * 2) && ($current_page < $range)) || (($current_page > $number_of_pages - $range) && ($i + 1 >= $number_of_pages - $range * 2)))) {
                echo '<li';
                echo ($current_page == $i + 1) ? ' class="active" ' : '';
                echo "><a href='$base_url/$section/$filter/" . $_GET['subaction'] . "/sort/{$_GET['sorton']}/{$_GET['desc']}/" . ($i + 1) . "'>" . ($i + 1) . "</a></li>";
            }
        }
        echo '<li';
        if ($current_page == $number_of_pages) {
            echo ' class="disabled"><a href="#"';
        } else {
            echo "><a href='$base_url/$section/$filter/" . $_GET['subaction'] . "/sort/{$_GET['sorton']}/{$_GET['desc']}/" . ($current_page + 1) . "'";
        }
        echo '>Next</a></li>
      </ul>
    </div>';
    }

}

?>
