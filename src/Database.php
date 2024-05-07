<?php

namespace Parkeren;
interface Database
{
    public function __construct(string $host, string $dbname, string $username, string $password);

    public function disconnect();

    public function select(string $table, array $columns = ['*'], array $where = []);

    public function insert(string $table, array $param);

    public function update(string $table, array $data, string $where);

    public function delete(string $table);
}