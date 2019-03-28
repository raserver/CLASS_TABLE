<?php
/*
 *  Example - get one specified column from table
 */


// Include Table class

    require_once 'class.table.php';

    
/*
 *  Init new Table object with database parameters specified in db_params.php
 *  In this example the name of your table is 'table1'
 */
    
    $some_table = new Table('table1');

    
// Set the name of column (field) you want to get form table (here we get column with field's name = 'field1')
    
    $some_table -> column = 'field1';
    
    
    $my_data = $some_table ->getColumn();
    
    
    if ($my_data !== FALSE) {
        
        var_dump($my_data);
        
    }


?>