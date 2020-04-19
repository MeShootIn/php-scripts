<?php

require_once '../rb/rb.php';

class Config {
    public const host = 'localhost';
    public const username = 'root';
    public const password = '';
    public const dbname = 'db';
    public const tablename = 'users';
    
    public const dsn = 'mysql:host=' . self :: host . ';dbname=' . self :: dbname;
}

R :: setup(Config :: dsn, Config :: username, Config :: password);
session_start();

?>