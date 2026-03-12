<?php

namespace App\Filters;

class GenreFilter extends Filter {
    protected function filters(): array {
        return [
            'name' => 'filterName',           
        ];
    }

    protected function allowed(): array {
        return array_keys($this->filters());
    }
    
    protected function filterName($value) {
        $this->builder->where('name', 'LIKE', "%{$value}%");
    }
}