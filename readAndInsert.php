<?php

    class Alter_Database {
        public $dbHostname = '192.168.1.215';
        public $dbUsername = 'root';
        public $dbPassword = 'cms-8341';
        public $db ='mysql';
        public $conn;

        public function connectDatabase()
        {

            $this->conn = new mysqli(
                $this->dbHostname, 
                $this->dbUsername, 
                $this->dbPassword,
                $this->db
            );

            if(!$this->conn){
                die('Error In connection'.mysqli_connect_error());
            }else{
                echo 'Connection Success<br>';
            }
        }

        public function insertMultipleRow($tableName)
        {
            $startRow = 1; //assign first row
            $insertQuery = "INSERT INTO $tableName (id, text, num, time) VALUES "; //command insert records
            $subQuery = ""; //create string value records

            //condition check file .csv exist
            if (($csvFile = fopen("/htdocs/intern/million.csv", "r")) !== false) {
                $tempCount = 0; 

                while (($readData = fgetcsv($csvFile, 1000, ",")) !== false) {
                    $columnCount = count($readData); //count column of .csv file
                    $subQuery = $subQuery . " ("; //handle string to fit format command query mysql
                    $tempCount++;
                    $startRow++;


                    for ($c = 0; $c < $columnCount; $c++) {;
                        $subQuery = $subQuery  . '"'. $readData[$c] .'"' . ','; //handle string to fit format command query mysql
                    }

                    $time = date("h:i:s", time()); //assign time variable to see processing time
                    $subQuery = $subQuery . '"' . $time . '"'; //handle string to fit format command query mysql
                    $subQuery = $subQuery. '),'; //handle string to fit format command query mysql

                    //condition divide group value records in one caommand insert
                    if ($tempCount % 50 == 0) {
                        $insertQuery = $insertQuery . $subQuery; //handle string to fit format command query mysql
                        $insertQuery = substr($insertQuery, 0, strlen($insertQuery) - 2); //handle string to fit format command query mysql
                        $insertQuery = $insertQuery. ')'; //handle string to fit format command query mysql

                        //condition insert records into database
                        if (mysqli_Query($this->conn, $insertQuery)) {
                            echo "<br>New record created successfully - ".$tempCount;
                            $insertQuery = "INSERT INTO $tableName (`id`, `text`, `num`, `time`) VALUES ";
                            $subQuery = "";
                        } else {
                            echo "Error: " . mysqli_error($this->conn). '<br>';
                        }
                    }
                }
                fclose($csvFile); //close .csv file
                mysqli_close($this->conn); //close connect databse
            } else {
                echo "File not found!";
            }
            
        }
    }
    $output = new Alter_Database;
    $output->connectDatabase();
    $output->insertMultipleRow('milion');
?>