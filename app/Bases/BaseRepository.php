<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/15 0015
 * Time: 14:33
 */

namespace App\Bases;

use App\Bases\Interfaces\BaseRepositoryInterface;

/**
 * Date: 2021/1/25 08:23:17
 * Author: Rex
 */
class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var mixed
     */
    public $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->model = model();
    }

    /**
     * @param array $data
     *
     * @return mixed
     * Date: 2021/1/25 08:23:17
     * Author: Rex
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     *
     * @return mixed
     * Date: 2021/1/25 08:23:17
     * Author: Rex
     */
    public function destroy($id)
    {
        return $this->model::destroy($id);
    }

    /**
     * @param       $id
     * @param array $data
     *
     * @return mixed
     * Date: 2021/1/25 08:23:17
     * Author: Rex
     */
    public function update($id, array $data)
    {
        return $this->model->where('id', '=', $id)->update($data);
    }
}