<?php
/**
 * Created by PhpStorm.
 * User: Marat.Komarov
 * Date: 19.12.2018
 * Time: 14:26
 */

namespace app\classes;

/**
 * Interface DbDriverContract
 * @package app\classes
 */
interface DbDriverContract
{
    /**
     * @param string $table
     * @param array $fields
     * @param string $conditions
     * @return array
     */
    public function result(string $table, array $fields = [], string $conditions = ''): array;

    /**
     * @param string $table
     * @param array $data
     * @return mixed
     */
    public function store(string $table, array $data);
}