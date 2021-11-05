<?php

namespace App\Bases\Interfaces;

interface BaseRepositoryInterface
{

//    public function find($conditions, $columns = []);   //查询一条数据
//
//    public function findBy($conditions, $column);   //查询单条数据的单个字段
//
//    public function findAll($conditions, $columns = []);    //查询多条数据
//
//    public function findAllBy($conditions, $column);    //查询多条数组的单个字段数组
//
//    public function filterFind($conditions, $columns = []); //过滤查询条件中的空值查询一条数据
//
//    public function filterFindAll($conditions, $columns = []);   //过滤查询条件中的空值查询多条数据
//
//    public function paginate($conditions = [], $columns = [], $size = 10, $current = null); //分页查询数据
//
//    public function getFilterModel($conditions, $columns = []); //获取已经过滤处理查询条件的 model
//
//    public function findCondition($conditions = [], $columns = []); //获取已经处理查询条件的 model(上面所有查询方法都基于这个方法)
//
    /**
     * @param array $data
     * @return array
     */
    public function store(array $data);    //添加数据

    public function update($id, array $data);   //修改数据 (使用的是批量修改)
//
    public function destroy($id);    //删除数据 (使用的是批量删除)

}

