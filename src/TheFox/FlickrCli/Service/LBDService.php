<?php

namespace TheFox\FlickrCli\Service;

class LBDService
{
    private $db = null;

    public function __construct($path)
    {
        $dbPath = $path . '/.uploaded.db';
        if (!file_exists($dbPath)) {
            $this->db = new \SQLite3($dbPath);
            $this->db->exec('CREATE TABLE ulist (id STRING, name STRING, album STRING, udate date)');
        } else {
            $this->db = new \SQLite3($dbPath);
        }
        return $this->db;
    }

    public function close() 
    {
        $this->db->close();
    }

    public function add($id, $filename, $album)
    {
        $sql = "INSERT INTO ulist (id, name, album, udate) VALUES ('".$id."','".$filename."','".$album."','".(new \DateTime)->format('Y-m-d H:i:s')."')";
        $this->db->exec($sql);
    }

    public function isUploaded($filename) 
    {
        $query = "SELECT id, name, album, udate FROM ulist WHERE name='".$filename."';";
        $result = $this->db->query($query);
        return $result->fetchArray();
    }
}
