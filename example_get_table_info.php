<?php
/*
 *  Example - get info about table
 */


// Include Table class

    require_once 'class.table.php';

    
/*
 *  Init new Table object with database parameters specified in db_params.php
 *  In this example the name of your table is 'table1'
 */
    
    $some_table = new Table('table1');

    
    $table_info = $some_table ->getTableSize();
    
    
    if ($table_info !== FALSE) {
        
        echo 'Number of columns = ' . $table_info['columns_count'] . '<br>';
        
        echo 'Number of rows = ' . $table_info['rows_count'];
        
    }
    
    

?>