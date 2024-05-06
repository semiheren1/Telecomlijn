<?php

class Mysql implements Database
{
    public static $db;

    public function __construct(string $host, string $dbname, string $username, string $password)
    {
        try
        {
            self::$db = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }catch(PDOException $error)
        {
            throw new Exception($error->getMessage());
        }
    }

    public function select(string $table, array $columns = ['*'], array $where = [])
    {
        try {
            // Build the SELECT query
            $selectColumns = implode(', ', $columns);
            $sql = "SELECT $selectColumns FROM $table";

            if (!empty($where)) {
                $whereConditions = [];
                foreach ($where as $key => $value) {
                    $whereConditions[] = "$key = :$key";
                }
                $sql .= " WHERE " . implode(' AND ', $whereConditions);
            }

            $query = self::$db->prepare($sql);

            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    $query->bindValue(":$key", $value);
                }
            }

            $query->execute();

            // Fetch and return the results as an associative array
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            throw new Exception($error->getMessage());
        }
    }


    public function update(string $table, array $data, string $where)
    {
        try {
            $sql = "UPDATE $table SET ";
            $values = [];

            foreach ($data as $key => $value) {
                $sql .= "$key = :$key, ";
                $values[":$key"] = $value;
            }

            $sql = rtrim($sql, ', ');
            $sql .= " WHERE `id` = :where"; // Use a placeholder for $where

            // Add the $where value to the $values array
            $values[':where'] = $where;

            $stmt = self::$db->prepare($sql);
            $stmt->execute($values);

            return $stmt->rowCount() > 0; // Check if any rows were affected
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function delete(string $table)
    {
        try
        {
            $sql = "DELETE FROM {$table}";
            $sql .= " WHERE `id` = {$_POST['id']}";

            $stmt = self::$db->prepare($sql);
            $stmt->execute();
        }
        catch(PDOException $e)
        {
            throw new PDOException("Error! " . $e);
        }

    }

    public function insert(string $table, $params = []) : void
    {
        try {

            $columns = implode(',', array_keys($params));
            $values = ":" . implode(' , :', array_keys($params));
            //It can be $insert or $query
            $insert =  self::$db->prepare("INSERT INTO $table($columns) VALUES ($values)");
            foreach ($params as $key => $value) {
                $insert->bindValue(':' . $key, $value);
            }
            $insert->execute();
        } catch(PDOException $error)
        {
            throw new Exception($error->getMessage());
        }
    }

    public function disconnect()
    {
        try
        {
            self::$db = null;
        }catch(PDOException $error)
        {
            throw new Exception($error->getMessage());
        }
    }
}