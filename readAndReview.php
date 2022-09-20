<?php
    echo '<table border="1">';
    $start_row = 1;
    $insertquery =
        "INSERT INTO `million` (`id`, `text`, `num`) VALUES ";
    $subquery = "";
    if (($csv_file = fopen("/htdocs/intern/million.csv", "r")) !== false) {
        while (($read_data = fgetcsv($csv_file, 1000, ",")) !== false) {
            $column_count = count($read_data);
            $subquery = $subquery . " (";
            echo "<tr>";
            $start_row++;
            for ($c = 0; $c < $column_count; $c++) {
                echo "<td>" . $read_data[$c] . "</td>";
                $subquery = $subquery . '\'' . $read_data[$c] . '\',';
            }
            echo "</tr>";
            $date = date("m/d/Y h:i:s a", time());
            $subquery = $subquery . '\'' . $date . '\'';
            $subquery = substr($subquery, 0, strlen($subquery) - 2);
            $subquery = $subquery . '\')' . " , ";
        }
        $insertquery = $insertquery . $subquery;
        $insertquery = substr($insertquery, 0, strlen($insertquery) - 2);
        echo $insertquery;
        fclose($csv_file);
    }
    echo "</table>";
?>