<?php
    backup_tables('192.168.1.215','root','cms-8341','students');

    /* backup the db OR just a table */
    function backup_tables($host,$user,$pass,$name,$tables = '*')
    {
        $link = mysqli_connect($host,$user,$pass);
        mysqli_select_db($name,$link);
        
        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        /* check if server is alive */
        if (mysqli_ping($link)) {
            printf ("Our connection is ok!\n");
        } else {
            printf ("Error: %s\n", mysqli_error($link));
        }
        //get all of the tables
        if($tables == '*')
        {
            $tables = array();
            $result = mysqli_query($link, 'SHOW TABLES');
            while($row = mysqli_fetch_row($result))
            {
                $tables[] = $row[0];
            }
            print_r($tables);
        }
        else
        {
            $tables = is_array($tables) ? $tables : explode(',',$tables);
            print_r($tables);
        }
        
        //cycle through
        // foreach($tables as $table)
        // {
        //     $result = mysqli_query('SELECT * FROM '.$table);
        //     $num_fields = mysqli_num_fields($result);
            
        //     $return= 'DROP TABLE '.$table.';';
        //     $row2 = mysqli_fetch_row(mysqli_query('SHOW CREATE TABLE '.$table));
        //     $return.= "\n\n".$row2[1].";\n\n";
            
        //     for ($i = 0; $i < $num_fields; $i++) 
        //     {
        //         while($row = mysqli_fetch_row($result))
        //         {
        //             $return.= 'INSERT INTO '.$table.' VALUES(';
        //             for($j=0; $j < $num_fields; $j++) 
        //             {
        //                 $row[$j] = addslashes($row[$j]);
        //                 $row[$j] = ereg_replace("\n","\\n",$row[$j]);
        //                 if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
        //                 if ($j < ($num_fields-1)) { $return.= ','; }
        //             }
        //             $return.= ");\n";
        //         }
        //     }
        //     $return.="\n\n\n";
        // }
        
        // //save file
        // $handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
        // fwrite($handle,$return);
        // fclose($handle);
    }
?>