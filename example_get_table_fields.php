<?php
/*
 *  Example - get fields names of table
 */


// Include Table class

    require_once 'class.table.php';

    
/*
 *  Init new Table object with database parameters specified in db_params.php
 *  In this example the name of your table is 'table1'
 */
    
    $some_table = new Table('table1');
    

    $fields_names = $some_table -> getTableFields();
    
    
    
    if ($fields_names !== FALSE) {
        
        var_dump($fields_names);
        
    }


?>