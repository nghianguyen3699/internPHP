<?php
    class Create_Table_Database {
        public function createRow($quantity = 0, $inputName)
        {   
            $fileName = $inputName . "_". date('y-m-d') . ".csv";
            for ($x = 1; $x <= $quantity; $x++) {
                echo $x.','."The number is: $x ".','.$x."\n";
            }
            header("Content-Type: text/csv");
            header('Content-Disposition: attachement; filename="' . $fileName . '"');
        }

    }
    $output = new Create_Table_Database;
    $output->createRow(100, "million");
?>