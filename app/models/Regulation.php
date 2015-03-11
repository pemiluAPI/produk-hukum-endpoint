<?php

class Regulation extends \Eloquent 
{
	protected $fillable = array('id','category','title','description','file_url','url');
	protected $hidden = array('created_at', 'updated_at');
	protected $table = 'regulations';

	public function category()
	{
		return $this->hasOne('Category', 'id', 'category_id');
	}

	public function getIdAttribute($value)
	{
		return intval($value);
	}

	public function getCategoryIdAttribute($value)
	{
		return intval($value);
	}

	public function allRegulationsPagedEloquent($limit=100, $offset=0, $params=array('category'=>null))
	{
		return Regulation::with('category')->skip($offset)->take($limit)->get()->toArray();
	}

	public function allRegulationsPaged($limit=100, $offset=0, $params=array('category'=>null, 'simple'=>TRUE, 'search'=>null))
	{
		$thisTable = $this->table;
		if ($params['simple'])
		{
			$query = DB::table($this->table);

			// Search by Category
			if (!empty($params['category']))
			{
				$query = $query->where("categories.id", '=', $params['category']);
			}

			// Search by title or description
			if (!empty($params['search']) && ($params['search'] !== TRUE))
			{
				$paramSearch = $params['search'];

				$query = $query->where(function($groupQuery) use ($thisTable, $paramSearch)
					{
						$groupQuery
							->orWhere("{$thisTable}.title", 'LIKE', "%{$paramSearch}%")
							->orWhere("{$thisTable}.description", 'LIKE', "%{$paramSearch}%");
					});
			}

			$query = $query
				->join('categories', "{$this->table}.category_id", '=', 'categories.id')
				->select(
					"{$this->table}.id",
					"{$this->table}.title",
					"{$this->table}.description",
					"{$this->table}.file_url",
					"{$this->table}.url",
					"categories.source as source",
					"categories.id as category_id",
					"categories.name as category_name"
					)
				->skip($offset)->take($limit)
				->get();

			return $query;
		}
		else
		{
			return $this->allRegulationsPagedEloquent($limit, $offset, $params);
		}
	}

	public function oneRegulation($regulation_id)
	{
		return DB::table($this->table)
			->where("{$this->table}.id", '=', $regulation_id)
			->join('categories', "{$this->table}.category_id", '=', 'categories.id')
			->select(
				"{$this->table}.id",
				"{$this->table}.title",
				"{$this->table}.description",
				"{$this->table}.file_url",
				"{$this->table}.url",
				"categories.source as source",
				"categories.id as category_id",
				"categories.name as category_name"
				)
			->get();
	}
}
