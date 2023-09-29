<?php

declare(strict_types=1);

namespace App\Core\DB;

use App\Core\Application;
use App\Core\Model;

abstract class DbModel extends Model
{
    abstract static public function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($attr) => ":{$attr}", $attributes);
        $sql = "INSERT INTO $tableName (" . implode(',', $attributes) . ") 
            VALUES (" . implode(',', $params) . ")";

        try {
            $statement = self::prepare($sql);

            foreach ($attributes as $attribute) {
                $statement->bindValue(":{$attribute}", $this->{$attribute});
            }

            $statement->execute();
        } catch (\Throwable $th) {
            echo "A Problem in saving this model" . PHP_EOL; // TODO: throw this exception
            return false;
        }

        return true;
    }

    public static function prepare(string $sql): \PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public static function findOne(array $where): static|bool
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $whereSql = implode(" AND ", array_map(fn($attr) => "{$attr} = :{$attr}", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE " . $whereSql);
        
        foreach ($where as $attr => $value) {
            $statement->bindValue(":{$attr}", $value);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}