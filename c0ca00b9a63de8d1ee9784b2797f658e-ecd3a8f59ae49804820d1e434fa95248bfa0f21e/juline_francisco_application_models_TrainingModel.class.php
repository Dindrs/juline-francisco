<?php

class TrainingModel
{
    function get_all() :array
    {
        $database = new Database();
        $sql = 'SELECT id,title, content, image, creation_date, category
                FROM training order by creation_date desc';

        return $database->query($sql);
    }

    function get_all_from_category(string $title) :array {

        $database = new Database();

        $sql = 'SELECT category.id, category.title, training.id, training.title, content, image, training.creation_date, category
                FROM training
                INNER JOIN category  on training.category = category.title
                WHERE category.title = ?';

        return $database->query($sql, [$title]);

    }

    function get_one(int $id) :array
    {
        $database = new Database();
        $sql = 'SELECT id,title, content, image, creation_date, category
                FROM training WHERE id = ?';

        return $database->queryOne($sql, [$id]);
    }

    public function add(string $title, string $content, string $image, string $category) :void
    {

        $database = new Database();
        $sql = 'INSERT INTO training (title, content, image, creation_date, category)
                VALUE(?,?,?, now(), ?)';

        $database->executeSql($sql, [$title, $content, $image, $category]);
    }

    public function remove(int $workout_id) :void
    {
        $database = new Database();
        $sql = 'DELETE FROM training 
                WHERE id = ?';

        $database->executeSql($sql, [$workout_id]);
    }

    public function update(string $title, string $content, string $category, int $id) :void
    {
        $database = new Database();
        $sql = 'UPDATE  training SET title = ?, content = ?, creation_date = NOW(), category = ?
                WHERE id = ?';

        $database->executeSql($sql, [$title, $content, $category, $id]);

    }
    
}