<?php

/* 
 * PHP 7.x  Class Table, typical CRUD class which allows add, edit, read and delete records/fields/tables of any MySQL database
 * 
 * 2019, ra-server.pl
 * 
 * Licence: free to use and edit
 */

require 'db_params.php';

class Table {

    // name of table to work with
    public $table_name;
    
    // connection object
    public $dbo;

    // id of record (id main column, auto update)
    public $id;

    // name of column (field)
    public $column;
    
    // array of new data to insert / update
    public $new_data;

    // limit of records
    public $limit;
    
    // array of conditions of operation
    public $conditions;
    
    // string query
    public $string_query;
    


    // Contructor
    public function __construct($table_name) {
        
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";

        try {
            $this -> dbo = new PDO($dsn, DB_USER , DB_PASS);
        }

        catch (Exception $e) {
            
            die('Error ! Database connection can not be estabilished !');
            
        }

        $this -> dbo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        
        $this -> dbo -> exec("set names utf8");
        
        $this -> table_name = $table_name;
        
    }        

    
    // Destructor
    public function __destruct() {
        
        $this -> dbo = NULL;
        
        $this -> table_name = "";
        
    }
    
    
    // Function checking if table exists
    public function ifTableExists() {
        
        $result = TRUE;
        
        if (trim($this -> table_name == '')) { return FALSE; }  // empty table name or table does not exist
        
        try {
            
            $res = $this -> dbo -> query("SELECT 1 FROM " . $this -> table_name . "  LIMIT 1");
            
        } catch (Exception $e) {
    
            $result = FALSE;  // table does not exist
            
        }
        
        return $result;
        
    }

    
    /* 
     *  Get whole table
     *  Function returns array of table_values
     *  or returns FALSE, if table is empty
     */
    public function getTable() {
        
        $table_values = [];
        
        if ($this -> ifTableExists() !== FALSE) {  // if table exists

            $st = $this -> dbo -> prepare("SELECT * FROM  " . $this -> table_name);

            $st -> execute();

            if ($st -> rowCount() > 0) {

                foreach ($st as $row) {

                    $table_values[] = $row;

                }

            }

            return $table_values;

            } else {
                
                return FALSE;
                
            }
    }
    
    
    /* 
     *  Get size of table
     *  Function returns array [count of rows, count of columns]
     *  or returns FALSE, if table is empty
     */
    public function getTableSize() {
        
        $table_values = [];
        
        if ($this -> ifTableExists() !== FALSE) {  // if table exists

            $st = $this -> dbo -> prepare("SELECT * FROM  " . $this -> table_name);

            $st -> execute();

            return [
                    'rows_count' => $st -> rowCount(),
                    'columns_count' => $st -> columnCount()
                    ];

            } else {
                
                return FALSE;
                
            }
    }
    
    
    
    /* 
     *  Get one record with specified id, or returns FALSE if record/table does not exist
     */ 
    public function getRecord() {
        
        if ($this -> ifTableExists() !== FALSE) {  // if table exists
        
            $query = "SELECT * FROM " . $this -> table_name . " WHERE id=:id LIMIT 1";

            $st = $this -> dbo -> prepare($query);

            $st -> bindValue(':id', $this -> id, PDO::PARAM_INT);

            $st -> execute();

            if ($st -> rowCount() > 0) {

                $record_values = $st -> fetchAll(PDO::FETCH_ASSOC);

            } else {

                return FALSE;

            }

            return $record_values;
            
        } else { return FALSE; }
        
    }

    
    /*
     *   Get table column with specified field's name
     *   Function returns array with column's values
     *   or returns FALSE, if column with such name does not exists or table does not exist
     */
    public function getColumn() {
        
        $table_values = [];

        if ($this -> ifTableExists() !== FALSE) {  // if table exists
        
            $query = "SELECT " . $this -> column . " FROM " . $this -> table_name;

            $st = $this -> dbo -> prepare($query);

            $st -> execute();
            
            $row_name = $this -> column;

            if ($st ->columnCount() > 0) {
                
                foreach ($st as $row) {
                    
                    $column_values[] = $row[$row_name];
                    
                }

            } else {

                return FALSE;

            }

            return $column_values;
            
        } else { return FALSE; }
        
    }

    
    /*
     *  Get table fields
     *  Function returns array with names of fields (column header)
     */
    public function getTableFields() {
        
        if ($this -> ifTableExists() !== FALSE) {  // if table exists
        
            $st = $this -> dbo -> prepare("DESCRIBE " . $this -> table_name);

            $st -> execute();

            $table_fields_names = $st -> fetchAll(PDO::FETCH_COLUMN);

            return $table_fields_names;

            } else {
                
                return FALSE;
                
            }
            
    }
    
    
    /*
     *  Insert record
     *  Function inserts record into table
     *  Returns FALSE if failed: array with new values is empty or table does not exist;
     *  or last inserted ID, if success
     */
    public function insertRecord() {
        
        $counter = 0;
        
        $fields = '';
        
        $values = '';

        if (count($this -> new_data) == 0) { return FALSE; }  // array with new data is empty
        
        if ($this -> ifTableExists() !== FALSE) {  // if table exists
            
            foreach ($this -> new_data as $key => $val) {
                
                $counter++;
                
                if ($counter == count($this -> new_data)) {  // last key/value
                    
                    $fields .= $key;
                    
                    $values .= ':val_' . $counter;
                    
                } else {
                    
                    $fields .= $key . ',';
                    
                    $values .= ':val_' . $counter . ',';
                    
                }
                
            }

            $query = "INSERT INTO " . $this -> table_name . ' (' . $fields . ') VALUES (' . $values . ')';
            
            $st = $this -> dbo -> prepare($query);
            
            $counter = 0;
            
            foreach ($this -> new_data as $val) {
                
                $counter++;
                
                $par = ':val_' . $counter;
                
                $st ->bindValue($par, $val);
                
            }
            
            $st -> execute();
            
            return $this -> dbo -> lastInsertId();
            
        } else {

            return FALSE;

        }
        
    }
    
    
   /* 
     *  Get whole table with limit of records
     *  Function returns array of table_values
     *  or returns FALSE if table is empty or table does not exist
     */
    public function getTableWithLimit() {
        
        $table_values = [];
        
        if ($this -> ifTableExists() !== FALSE) {  // if table exists

            $st = $this -> dbo -> prepare("SELECT * FROM  " . $this -> table_name . " LIMIT " . $this -> limit);

            $st -> execute();

            if ($st -> rowCount() > 0) {

                foreach ($st as $row) {

                    $table_values[] = $row;

                }

            }

            return $table_values;

            } else {
                
                return FALSE;
                
            }
    }
    
    
    /* 
     *  Get whole table with limit of records in DESC order
     *  Function returns array of table_values
     *  or returns FALSE if table is empty or table does not exist
     */
    public function getTableWithLimitDesc() {
        
        $table_values = [];
        
        if ($this -> ifTableExists() !== FALSE) {  // if table exists

            $st = $this -> dbo -> prepare("SELECT * FROM  " . $this -> table_name . " ORDER BY id DESC LIMIT " . $this -> limit);

            $st -> execute();

            if ($st -> rowCount() > 0) {

                foreach ($st as $row) {

                    $table_values[] = $row;

                }

            }

            return $table_values;

            } else {
                
                return FALSE;
                
            }
    }
    
    
    /* 
     *  Get whole table with limit of records in ASC order
     *  Function returns array of table_values
     *  or returns FALSE if table is empty or table does not exist
     */
    public function getTableWithLimitAsc() {
        
        $table_values = [];
        
        if ($this -> ifTableExists() !== FALSE) {  // if table exists

            $st = $this -> dbo -> prepare("SELECT * FROM  " . $this -> table_name . " ORDER BY id ASC LIMIT " . $this -> limit);

            $st -> execute();

            if ($st -> rowCount() > 0) {

                foreach ($st as $row) {

                    $table_values[] = $row;

                }

            }

            return $table_values;

            } else {
                
                return FALSE;
                
            }
    }
        
    
    /*
     *  Delete one record from table
     *  Function removes specified record (id) from table
     *  Returns FALSE if table does not exist
     */
    public function deleteRecord() {
        
            if ($this -> ifTableExists() !== FALSE) {  // if table exists
        
                $query = "DELETE FROM " . $this -> table_name . " WHERE id=:id LIMIT 1";

                $st = $this -> dbo -> prepare($query);

                $st -> bindValue(':id', $this -> id, PDO::PARAM_INT);

                $st -> execute();    
        
            }    
        
    }
    
    
    /* 
     *  Get whole table with string query
     *  Function returns array of table_values
     *  or returns FALSE if table is empty or table does not exist
     */
    public function getTableWithQuery() {
        
        $table_values = [];
        
        if ($this -> ifTableExists() !== FALSE) {  // if table exists

            $st = $this -> dbo -> prepare("SELECT * FROM  " . $this -> table_name . " WHERE " . $this -> string_query);

            $st -> execute();

            if ($st -> rowCount() > 0) {

                foreach ($st as $row) {

                    $table_values[] = $row;

                }

            }

            return $table_values;

            } else {
                
                return FALSE;
                
            }
    }
    
    
    /*
     *  Update record
     *  Function updates record of table
     *  Returns FALSE if failed: array with new values is empty or table does not exist;
     *  or last inserted ID, if success
     */
    public function updateRecord() {
        
        $counter = 0;
        
        $fields = '';

        if (count($this -> new_data) == 0) { return FALSE; }  // array with new data is empty
        
        if ($this -> ifTableExists() !== FALSE) {  // if table exists
            
            foreach ($this -> new_data as $key => $val) {
                
                $counter++;
                
                if ($counter == count($this -> new_data)) {  // last key/value
                    
                    $fields .= $key . '= :val_' . $counter;
                    
                } else {
                    
                    $fields .= $key . '= :val_' . $counter . ',';
                    
                }
                
            }

            $query = "UPDATE " . $this -> table_name . ' SET ' . $fields . ' WHERE ' . $this -> string_query;
            
            $st = $this -> dbo -> prepare($query);
            
            $counter = 0;
            
            foreach ($this -> new_data as $val) {
                
                $counter++;
                
                $par = ':val_' . $counter;
                
                $st ->bindValue($par, $val);
                
            }
            
            $st -> execute();
            
            return TRUE;
            
        } else {

            return FALSE;

        }
        
    }
    
    
    
    
    
    
}
    

?>
