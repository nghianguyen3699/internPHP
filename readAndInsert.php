<?php
    require('dbConfig.php');
    class Alter_Database {

        public function insertMultipleRow($tableName)
        {   
            global $conn;
            $insertQuery = "INSERT INTO $tableName (id, text, num, time) VALUES "; //command insert records
            $subQuery = ""; //create string value records

            //condition check file .csv exist
            if (($csvFile = fopen("/htdocs/intern/million.csv", "r")) !== false) {
                $tempCount = 0; //number of record to insert for each command

                while (($readData = fgetcsv($csvFile, 1000, ",")) !== false) {
                    $columnCount = count($readData); //count column of .csv file
                    $subQuery = $subQuery . " ("; //handle string to fit format command query mysql
                    $tempCount++; 


                    for ($c = 0; $c < $columnCount; $c++) {;
                        $subQuery = $subQuery  . '"'. $readData[$c] .'"' . ','; //handle string to fit format command query mysql
                    }

                    $time = date("h:i:s"); //assign time variable to see processing time
                    $subQuery = $subQuery . '"' . $time . '"'. '),'; //handle string to fit format command query mysql

                    //condition divide group value records in one caommand insert
                    if ($tempCount % 50 == 0) {
                        $insertQuery = $insertQuery . $subQuery; //handle string to fit format command query mysql
                        $insertQuery = substr($insertQuery, 0, strlen($insertQuery) - 2); //handle string to fit format command query mysql
                        $insertQuery = $insertQuery. ')'; //handle string to fit format command query mysql
                        
                        // echo '<br>' . $insertQuery . '<br>' . '<br>';
                        //condition insert records into database
                        if ($conn->query($insertQuery)) {
                            echo "<br>New record created successfully - ".$tempCount;
                            $insertQuery = "INSERT INTO $tableName (id, text, num, time) VALUES ";
                            $subQuery = "";
                        } else {
                            echo "Error: " . $conn->error. '<br>';
                        }
                    }
                }
                fclose($csvFile); //close .csv file
                $conn->close(); //close connect databse
            } else {
                echo "File not found!";
            }
            
        }
    }
    $output = new Alter_Database;
    $output->insertMultipleRow('milion');
?>