<?php 
    include 'dbConfig.php';

    function exportFile($table)
    {   
        $db = new mysqli("192.168.1.215", "root", "cms-8341", "mysql"); 

        $query = $db->query("SELECT * FROM $table ORDER BY id ASC"); 
     
        if($query->num_rows > 0){ 
            $delimiter = ","; 
            $filename = "million-data" . date('y-m-d') . ".csv"; 
            
            // Create a file pointer 
            $f = fopen('php://memory', 'w'); 
            
            // Set column headers 
            $fields = array('id', 'text', 'num', 'time'); 
            fputcsv($f, $fields, $delimiter); 
            
            // Output each row of the data, format line as csv and write to file pointer 
            while($row = $query->fetch_assoc()){ 
                $lineData = array($row['id'], $row['text'], $row['num'], $row['time']); 
                fputcsv($f, $lineData, $delimiter); 
            } 
            
            // Move back to beginning of file 
            fseek($f, 0); 

            //download file rather than displayed 
            header('Content-Type: text/csv'); 
            header('Content-Disposition: attachment; filename="' . $filename . '";'); 
            
            //output all remaining data on a file pointer 
            fpassthru($f); 
        } 
        exit;
    }
    exportFile('million');
?>