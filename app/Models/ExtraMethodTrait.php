<?php

namespace App\Models;

use Exception;
use DB;


trait ExtraMethodTrait
{
    /**
     * Sync relations
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @param bool $detaching
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function findToSync($id, $relation, $attributes, $detaching = true)
    {
        return static::find($id)->{$relation}()->sync($attributes, $detaching);
    }

    /**
     * SyncWithoutDetaching
     *
     * @param $id
     * @param $relation
     * @param $attributes
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function syncWithoutDetaching($id, $relation, $attributes)
    {
        return static::findToSync($id, $relation, $attributes, false);
    }

    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param null $limit
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function simplePaginate($limit = null, $columns = ['*'])
    {
        return static::paginate($limit, $columns, "simplePaginate");
    }

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function findByField($field, $value = null, $columns = ['*'])
    {
        $model = static::where($field, '=', $value)->first($columns);

        return $model;
    }

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function findWhere(array $where, $columns = ['*'])
    {
        $model = static::where($where)->first($columns);

        return $model;
    }

    /**
     * Find all data by multiple fields
     *
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public static function findAllWhere(array $where, $columns = ['*'])
    {
        $model = static::where($where)->get($columns);

        return $model;
    }

    /**
     * Retrieve all data with conditions and sort
     *
     * @param array $where
     * @param array $sort
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function findAllWhereSort($where = [], $sort = [], $columns = ['*'])
    {
        $model = static::query();

        if (!empty($where)) {
            foreach ($where as $column => $data) {
                if (is_array($data)) {
                    $model->whereIn($column, $data);
                } else {
                    $model->where($column, $data);
                }
            }
        }

        if (!empty($sort)) {
            foreach ($sort as $column => $direction) {
                $model->orderBy($column, $direction);
            }
        }

        return $model->get($columns);
    }

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function existsWhere(array $where, $columns = ['*'])
    {
        $model = static::where($where)->exists($columns);

        return $model;
    }

    /**
     * Find data by multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function findWhereIn($field, array $values, $columns = ['*'])
    {
        $model = static::whereIn($field, $values)->first($columns);

        return $model;
    }

    /**
     * Find data by excluding multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        $model = static::whereNotIn($field, $values)->first($columns);

        return $model;
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     *
     * @throws Exception
     */
    public static function updateById(array $attributes, $id)
    {
        $model = static::findOrFail($id);
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    /**
     * Update by conditions
     * @param array $attributes
     * @param array $where
     * @return mixed
     * @throws Exception
     */
    public static function updateWhere(array $attributes, array $where)
    {
        return static::where($where)->update($attributes);
    }

    /**
     * Update first by conditions
     *
     * @param array $attributes
     * @param array $where
     * @return mixed
     */
    public static function updateFirstWhere(array $attributes, array $where)
    {
        $model = static::where($where)->first();
        $model->fill($attributes);

        return $model->save();
    }

    /**
     * Delete multiple entities by given criteria.
     *
     * @param array $where
     *
     * @return int
     *
     * @throws Exception
     */
    public static function deleteWhere(array $where)
    {
        return static::where($where)->delete();
    }

    /**
     * Set new auto increment number.
     *
     * @param int $id
     * @throws Exception
     */
    public static function setAutoIncrement($id)
    {
        $tableName = static::getTable();

        DB::update("ALTER TABLE {$tableName} AUTO_INCREMENT = {$id};");
    }

    /**
     * Get auto increment id.
     *
     * @throws Exception
     */
    public static function getAutoIncrement()
    {
        $tableName = static::getTable();

        $statement = DB::select("SHOW TABLE STATUS LIKE '{$tableName}';");

        return $statement[0]->Auto_increment;
    }

    /**
     * Insert data.
     *
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public static function insert($data)
    {
        if (! is_array(reset($data))) {
            $data = [$data];
        }

        foreach ($data as &$row) {
            if (empty($row[static::CREATED_AT])) {
                $row[static::CREATED_AT] = now();
            }

            if (empty($row[static::UPDATED_AT])) {
                $row[static::UPDATED_AT] = now();
            }
        }

        return static::insert($data);
    }
}
