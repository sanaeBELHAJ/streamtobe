<?php

namespace App\Repositories;

abstract class ResourceRepository
{

    protected $model;
	
	/**
	 * Select All
	 */
    public function getPaginate($n)
	{
		return $this->model->paginate($n);
	}

	/**
	 * Create
	 */
	public function store(Array $inputs)
	{
		return $this->model->create($inputs);
	}

	/**
	 * Select By
	 */
	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}

	/**
	 * Update
	 */
	public function update($id, Array $inputs)
	{
		$this->getById($id)->update($inputs);
	}

	/**
	 * Delete
	 */
	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

}