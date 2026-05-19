<?php

namespace App\Filters;

class TitleFilter extends Filter {
    protected function filters(): array {
        return [
            'name'     => 'filterName',
            'genres'   => 'filterGenres',
            'media_id' => 'filterMediaId',
            'year'     => 'filterYear',
        ];
    }

    protected function allowed(): array {
        return array_keys($this->filters());
    }
    
    protected function filterName($value) {
        $this->builder->where('name', 'LIKE', "%{$value}%");
    }

    protected function filterGenres($value) {
        $genres = explode(',', $value);

        $this->builder->whereHas('genres', function ($q) use ($genres) {
            $q->whereIn('id', $genres);
        });
    }

    protected function filterMediaId($value) {
        $this->builder->where('media_id', $value);
    }

    protected function filterYear($value) {
        $this->builder->where('year', $value);
    }
}
