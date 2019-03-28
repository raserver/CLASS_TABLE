<?php
/*
 *  Example - update record
 */


// Include Table class

    require_once 'class.table.php';

    
/*
 *  Init new Table object with database parameters specified in db_params.php
 *  In this example the name of your table is 'table1'
 */
    
    $some_table = new Table('table1');
    
    
/*
 *  Set array with new values of  record you want to apdate. 'field1', 'field2', ... are the names of fields
 *  Note that new values must be compliant with fields' types of data (integer, text, datetime, etc.)
 */
    
    $new_values = [
        'field1' => 'my updated value 1',
        'field2' => 'my updated value 2',
        'field3' => 'my updated value 3',
        'field4' => 'my updated value 4'
    ];
   
    
/*
 *  Set the query (do not use 'WHERE', just condition(s) according to SQL syntax)
 *  In this case we want to update record with id = 3
 */
 
    $some_table -> string_query = 'id = 3';
    
    $some_table -> new_data = $new_values;
    
    $some_table -> updateRecord();


?>