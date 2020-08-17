<?php

class CategoryModel
{

    function get_all() :array
    {
        $database = new Database();
        $sql = 'SELECT id, title, creation_date
                FROM category ORDER BY creation_date asc ';

        return $database->query($sql);
    }

    function get_one(int $id) :array
    {
        $database = new Database();
        $sql = 'SELECT id, title FROM category WHERE id = ?';

        return $database->queryOne($sql, [$id]);
    }

    function add(string $title) :void
    {
        $database = new database();
        $sql = 'INSERT INTO category (title, creation_date) VALUE(?, NOW())';

        $database->executeSql($sql, [$title]);
    }

    function title_exists(string $title) :bool {

        $database = new Database();
        $sql = 'SELECT title FROM category WHERE title = ?';

        $title = $database->queryOne($sql, [$title]);


        return $title !== false;
    }

    function remove(int $id) :void
    {
        $database = new database();
        $sql = 'DELETE FROM category WHERE id = ?';

        $database->executeSql($sql, [$id]);
    }

    public function update(string $title, int $id)
    {
        $database = new Database();
        $sql = 'UPDATE  category SET title = ?, creation_date = NOW()
                WHERE id = ?';

        return $database->executeSql($sql, [$title, $id]);

    }

}