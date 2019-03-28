<?php
/*
 *  Example - delete one record from table with specified id
 */


// Include Table class

    require_once 'class.table.php';

    
/*
 *  Init new Table object with database parameters specified in db_params.php
 *  In this example the name of your table is 'table1'
 */
    
    $some_table = new Table('table1');
    
   

// Set the id of record you want to delete from the table (here we delete record id = 6)
    
    $some_table -> id = 6;

    
// Act and check the result
    
    $result = $some_table -> deleteRecord();
    
    if ($result !== FALSE) {
        
        echo 'Operation successful';
        
    } else {
        
        echo 'Operation failed. Check id parameter';
        
    }

    


?>