<?php
/*
 *  Example - add record
 */


// Include Table class

    require_once 'class.table.php';

    
/*
 *  Init new Table object with database parameters specified in db_params.php
 *  In this example the name of your table is 'table1'
 */
    
    $some_table = new Table('table1');
    
    
/*
 *  Set array with values of new record you want to add. 'field1', 'field2', ... are the names of fields
 *  Note that new values must be compliant with fields' types of data (integer, text, datetime, etc.)
 */
    
    $new_values = [
        'field1' => 'my new value 1',
        'field2' => 'my new value 2',
        'field3' => 'my new value 3',
        'field4' => 'my new value 4'
    ];
    
    
    $some_table -> new_data = $new_values;
    
    $last_inserted_id = $some_table ->insertRecord();
    
/*
 *  Function inserting new record returns id of new inserted record
 */
    
    echo   'last inserted id = ' .$last_inserted_id;
    


?>