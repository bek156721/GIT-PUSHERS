<?php
const DBHOST = "localhost";
const DBUSER = "root";
const PASSWORD = "";
const DB = "sec_ete_db";


$conexion = mysqli_connect(DBHOST, DBUSER, PASSWORD, DB);

if (!$conexion)
    {
        die("Conexión fallida: ". mysqli_connect_error());
    }