<?php

namespace App\Services;

use App\Services\Utils\FileUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;

/**
 * BaseService
 */
class BaseService
{
    protected Model $model;

    protected $fileUploadService;

    /**
     * __construct
     *
     * @param  mixed  $model
     * @return void
     */
     public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function createOrUpdateWithFile(array $data, $file_field_name, $id = null)
    {
        try {
            if ($id) {
                $data['updated_by'] = Auth::id();
                $object = $this->model->findOrFail($id);
                if (isset($data[$file_field_name]) && $data[$file_field_name] != null) {
                    $data[$file_field_name] = $this->uploadFile($data[$file_field_name], $object->$file_field_name);
                }

                return $object->update($data);
            } else {
                $data['created_by'] = Auth::id();
                if (isset($data[$file_field_name]) && $data[$file_field_name] != null) {
                    $data[$file_field_name] = $this->uploadFile($data[$file_field_name]);
                }

                return $this->model::create($data);
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * createOrUpdate
     *
     * @param  mixed  $data
     * @param  mixed  $id
     * @return void
     */
    public function createOrUpdate(array $data, $id = null)
    {
        try {
            if ($id) {
                $data['updated_by'] = Auth::id();

                return $this->model->findOrFail($id)->update($data);
            } else {
                $data['created_by'] = Auth::id();

                return $this->model::create($data);
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * get
     *
     * @param  mixed  $id
     * @param  mixed  $with
     * @param  mixed  $limit
     * @return void
     */
    public function get($id = null, $with = [], $limit = null, $scope = null)
    {
        try {

            if ($id) {
                $data = $this->model->with($with)
                    ->when($scope && ! is_array($scope), function ($query) use ($scope) {
                        return $query->$scope();
                    })
                    ->when($scope && is_array($scope), function ($query) use ($scope) {
                        foreach ($scope as $key => $value) {
                            $query->$value();
                        }

                        return $query;
                    })
                    ->find($id);

                return $data ? $data : false;
            } else {
                return $this->model->with($with)
                    ->when($scope && ! is_array($scope), function ($query) use ($scope) {
                        return $query->$scope();
                    })
                    ->when($scope && is_array($scope), function ($query) use ($scope) {
                        foreach ($scope as $key => $value) {
                            $query->$value();
                        }

                        return $query;
                    })
                    ->limit($limit)->get();
            }

        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function getWithPagination($id = null, $with = [], $column = null)
    {
        try {
            if ($id) {
                $data = $this->model->with($with)->where($column);

                return $data ? $data : false;
            } else {
                return $this->model->with($with)->paginate(20);
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * getActiveData
     *
     * @param  mixed  $id
     * @param  mixed  $with
     * @return void
     */
    public function getActiveData($id = null, $with = [])
    {

        try {
            if ($id) {
                $data = $this->model->with($with)->find($id);

                return $data ? $data : false;
            } else {
                return $this->model->with($with)->get();
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * delete
     *
     * @param  mixed  $id
     * @return void
     */
    public function delete($id)
    {
        try {
            $data = $this->model::findOrFail($id);

            return $data->delete();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function __call($name, $arguments)
    {
        $this->model->{$name}($arguments);
    }
    public function findOrNew($id=null){
        try {

            $model = new $this->model();

            if($model->created_by){
                $model->created_by = Auth::id();
            }

            if ($id){
                $model = $this->model->find($id);
                if($model->updated_by){
                    $model->updated_by = Auth::id();
                }
            }
            return $model;

        }catch (\Throwable $th){
            return false;
        }
    }
}
