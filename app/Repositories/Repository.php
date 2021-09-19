<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use App\Utilities\General;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Model;
use DB;

/**
 * Class Repository
 * @package App\Repositories
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Toggle config cache.
     * @var bool
     */
    protected $cached = false;

    /**
     * Specify Model class name
     *
     * @return Model
     *
     * @throws Exception
     */
    public function model()
    {
        return $this->makeModel();
    }

    /**
     * @return Model
     *
     * @throws Exception
     */
    public function makeModel()
    {
        if (empty($this->model)) {
            throw new Exception("Must assign property `model` to a Model class");
        }

        $model = app()->make($this->model);

        if (!$model instanceof Model) {
            $modelClass = $this->model;
            throw new Exception("Class {$modelClass} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $model;
    }

    /**
     * Retrieve data array for populate field select
     *
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     *
     * @throws Exception
     */
    public function lists($column, $key = null)
    {
        return $this->model()->lists($column, $key);
    }

    /**
     * Retrieve data array for populate field select
     * Compatible with Laravel 5.3
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     *
     * @throws Exception
     */
    public function pluck($column, $key = null)
    {
        return $this->model()->pluck($column, $key);
    }

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
    public function findToSync($id, $relation, $attributes, $detaching = true)
    {
        return $this->model()->findToSync($id, $relation, $attributes, $detaching);
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
    public function syncWithoutDetaching($id, $relation, $attributes)
    {
        return $this->findToSync($id, $relation, $attributes, false);
    }

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function all($columns = ['*'])
    {
        if ($this->cached) {
            $cacheKey = General::hexKey([$this->model()->getTable(), $columns]);

            $cachedData = cache($cacheKey, []);

            if (!empty($cachedData)) {
                return $cachedData;
            }
        }

        if ($this->model() instanceof Builder) {
            $results = $this->model()->get($columns);
        } else {
            $results = $this->model()->all($columns);
        }

        if (isset($cacheKey)) {
            cache([$cacheKey => $results], now()->addMinutes(config('database.cache_time', 1)));
        }

        return $results;
    }

    /**
     * Alias of All method
     *
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function get($columns = ['*'])
    {
        return $this->all($columns);
    }

    /**
     * Retrieve first data of repository
     *
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function first($columns = ['*'])
    {
        $results = $this->model()->first($columns);

        return $results;
    }

    /**
     * Retrieve first data of repository, or return new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function firstOrNew(array $attributes = [])
    {
        $model = $this->model()->firstOrNew($attributes);

        return $model;
    }

    /**
     * Retrieve first data of repository, or create new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function firstOrCreate(array $attributes = [])
    {
        $model = $this->model()->firstOrCreate($attributes);

        return $model;
    }

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null $limit
     * @param array $columns
     * @param array $orders
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function paginate($limit = null, $columns = ['*'], $orders = [])
    {
        $limit = is_null($limit) ? config('database.pagination.limit', 15) : $limit;

        $model = $this->model();

        foreach ($orders as $column => $orderType) {
            $model = $model->orderBY($column, $orderType);
        }

        $results = $model->paginate($limit, $columns);

        $results->appends(request()->query());

        return $results;
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
    public function simplePaginate($limit = null, $columns = ['*'])
    {
        return $this->model()->simplePaginate($limit, $columns);
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function find($id, $columns = ['*'])
    {
        $model = $this->model()->findOrFail($id, $columns);

        return $model;
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
    public function findByField($field, $value = null, $columns = ['*'])
    {
        $model = $this->model()->findByField($field, $value, $columns);

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
    public function findWhere(array $where, $columns = ['*'])
    {
        $model = $this->model()->findWhere($where, $columns);

        return $model;
    }

    /**
     * Find all data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     * @throws Exception
     */
    public function findAllWhere(array $where, $columns = ['*'])
    {
        $model = $this->model()->findAllWhere($where, $columns);

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
    public function findAllWhereSort($where = [], $sort = [], $columns = ['*'])
    {
        $model = $this->model()->findAllWhereSort($where, $sort, $columns );

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
    public function existsWhere(array $where, $columns = ['*'])
    {
        $model = $this->model()->existsWhere($where, $columns);

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
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        $model = $this->model()->findWhereIn($field, $values, $columns);

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
    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        $model = $this->model()->findWhereNotIn($field, $values, $columns);

        return $model;
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function create(array $attributes)
    {
        $model = $this->model()->newInstance($attributes);
        $model->save();

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
    public function update(array $attributes, $id)
    {
        $model = $this->model()->findOrFail($id);
        $model->fill($attributes);
        $model->save();

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
    public function updateById(array $attributes, $id)
    {
        $model = $this->model()->updateById($attributes, $id);

        return $model;
    }

    /**
     * Update by conditions
     * @param array $attributes
     * @param array $where
     * @return mixed
     * @throws Exception
     */
    public function updateWhere(array $attributes, array $where)
    {
        return $this->model()->updateWhere($attributes, $where);
    }

    /**
     * Update first by conditions
     *
     * @param array $attributes
     * @param array $where
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function updateFirstWhere(array $attributes, array $where)
    {
        $model = $this->model()->updateFirstWhere($attributes, $where);

        return $model;
    }

    /**
     * Update or Create an entity in repository
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model()->updateOrCreate($attributes, $values);
    }

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     *
     * @throws Exception
     */
    public function delete($id)
    {
        $model = $this->find($id);

        $deleted = $model->delete();

        return $deleted;
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
    public function deleteWhere(array $where)
    {
        return $this->model()->deleteWhere($where);
    }

    /**
     * Set new auto increment number.
     *
     * @param int $id
     * @throws Exception
     */
    public function setAutoIncrement($id)
    {
        $this->model()->setAutoIncrement($id);
    }

    /**
     * Get auto increment id.
     *
     * @throws Exception
     */
    public function getAutoIncrement()
    {
        return $this->model()->getAutoIncrement();
    }

    /**
     * Get max value of column.
     *
     * @param string $column
     * @return mixed
     * @throws Exception
     */
    public function max($column)
    {
        return $this->model()->max($column);
    }

    /**
     * Get max value of column.
     *
     * @param string $column
     * @return mixed
     * @throws Exception
     */
    public function min($column)
    {
        return $this->model()->min($column);
    }

    /**
     * Insert data.
     *
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function insert($data)
    {
        return $this->model()->insert($data);
    }
}
