<?php

namespace App\Filters;

class GenreFilter extends Filter {
    protected function filters(): array {
        return [
            'name' => 'filterName',
            'id'   => 'filterId'           
        ];
    }

    protected function allowed(): array {
        return array_keys($this->filters());
    }
    
    protected function filterName($value) {
        $this->builder->where('name', 'LIKE', "%{$value}%");
    }

    protected function filterId($value) {
        $this->builder->where('id', $value);
    }
}