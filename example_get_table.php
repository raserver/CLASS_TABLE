<?php
/*
 *  Example - get records from table
 */


// Include Table class

    require_once 'class.table.php';

    
/*
 *  Init new Table object with database parameters specified in db_params.php
 *  In this example the name of your table is 'table1'
 */
    
    $some_table = new Table('table1');

    
    $my_data = $some_table ->getTable();
    
    
    if ($my_data !== FALSE) {
        
        var_dump($my_data);
        
    }


?>