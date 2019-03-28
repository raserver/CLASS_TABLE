<?php
/*
 *  Example - get one specified row from table
 */


// Include Table class

    require_once 'class.table.php';

    
/*
 *  Init new Table object with database parameters specified in db_params.php
 *  In this example the name of your table is 'table1'
 */
    
    $some_table = new Table('table1');

    
// Set the id of row you want to get form table (here we get row with id = 2)
    
    $some_table -> id = 2;    
    
    
    $my_data = $some_table ->getRecord();
    
    
    if ($my_data !== FALSE) {
        
        var_dump($my_data);
        
    }


?>