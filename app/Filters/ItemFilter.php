<?php

namespace App\Filters;

class ItemFilter extends Filter {
    protected function filters(): array {
        return [
            'title'    => 'filterTitle',
            'genres'   => 'filterGenres',
            'type'     => 'filterType',
            'year'     => 'filterYear',
            'imdb_id'  => 'filterImdbId'            
        ];
    }

    protected function allowed(): array {
        return array_keys($this->filters());
    }
    
    protected function filterTitle($value) {
        $this->builder->where('title', 'LIKE', "%{$value}%");
    }

    protected function filterGenres($value) {
        $genres = explode(',', $value);

        $this->builder->whereHas('genres', function ($q) use ($genres) {
            $q->whereIn('id', $genres);
        });
    }

    protected function filterType($value) {
        $this->builder->where('type', $value);
    }

    protected function filterYear($value) {
        $this->builder->where('year', $value);
    }

    protected function filterImdbId($value) {
        $this->builder->where('imdb_id', $value);
    }
}