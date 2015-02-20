<?php

class Category extends \Eloquent 
{
	protected $fillable = array('id', 'name', 'source', 'url');
	protected $hidden = array('created_at', 'updated_at');
	protected $table = 'categories';

	public function regulations()
	{
		return $this->hasMany('Regulation', 'category_id', 'id');
	}

	public function getIdAttribute($value)
	{
		return intval($value);
	}

	public function allCategories()
	{
		return DB::table($this->table)
			->select(
				'id',
				'name',
				'source',
				'url'
				)
			->get();
	}
}