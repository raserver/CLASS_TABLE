<?php
/*
 *  Example - get records from table with limit of records
 */


// Include Table class

    require_once 'class.table.php';

    
/*
 *  Init new Table object with database parameters specified in db_params.php
 *  In this example the name of your table is 'table1'
 */
    
    $some_table = new Table('table1');
    

/*
 *  Set limit of records = 2
 */    
    
    $some_table -> limit = 2;
    
    
    $my_data = $some_table ->getTableWithLimit();
    
/*
 *  If you need data in ascending or descending order you may use
 *  getTableWithLimitAsc()
 *  or
 *  getTableWithLimitDesc()
 */    
    
    
    if ($my_data !== FALSE) {
        
        var_dump($my_data);
        
    }


?>