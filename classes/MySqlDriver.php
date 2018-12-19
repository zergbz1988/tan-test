<?php

namespace app\classes;

use PDO;

/**
 * Class MySqlDriver
 * @package app\classes
 */
class MySqlDriver implements DbDriverContract
{
    protected $pdo;

    public function __construct(string $dsn, string $user = null, string $pass = null, array $driverOptions = null)
    {
        $this->pdo = new PDO($dsn, $user, $pass, $driverOptions);
    }

    /**
     * @param string $source
     * @param array $fields
     * @param string $conditions
     * @return array
     */
    public function result(string $source, array $fields = [], string $conditions = ''): array
    {
        $stmt = $this->pdo->prepare('SELECT ' .
            $this->formattedFields($fields) . ' FROM ' . $source . ' WHERE ' . $conditions);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $fields
     * @return string
     */
    protected function formattedFields(array $fields): string
    {
        if ($fields) {
            return implode(', ', $fields);
        }
        return '*';
    }
}