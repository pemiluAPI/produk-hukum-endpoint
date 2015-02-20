<?php

class RegulationController extends BaseController {

	protected $regulation;

	public function __construct(Regulation $regulation)
	{
		$this->regulation = $regulation;
	}


	public function getAll()
	{
		$limit = Input::get('limit', 100);
		$offset = Input::get('offset', 0);
		$params = array();
		$params['category'] = Input::get('category', 0);
		$params['simple'] = Input::get('simple', TRUE);

		return XApi::parser( $this->regulation->allRegulationsPaged($limit, $offset, $params) );
	}

	public function getOne($id)
	{
		return XApi::parser( $this->regulation->oneRegulation($id) );
	}
}
