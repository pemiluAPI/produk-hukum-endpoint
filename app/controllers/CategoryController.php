<?php

class CategoryController extends BaseController {

    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }


    public function getAll()
    {
        return XApi::parser($this->category->allCategories());
    }
}
