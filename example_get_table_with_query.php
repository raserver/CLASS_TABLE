<?php
/*
 *  Example - get records from table with query
 */


// Include Table class

    require_once 'class.table.php';

    
/*
 *  Init new Table object with database parameters specified in db_params.php
 *  In this example the name of your table is 'table1'
 */
    
    $some_table = new Table('table1');
    
/*
 *  Set string query - must be compatible with SQL syntax
 */
    
    $some_table -> string_query = 'id > 1 AND id < 5';
    
    $my_data = $some_table ->getTableWithQuery();
    
    
    if ($my_data !== FALSE) {
        
        var_dump($my_data);
        
    }


?>