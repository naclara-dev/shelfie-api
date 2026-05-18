<?php

namespace App\Filters;

class RatingFilter extends Filter {
    protected function filters(): array {
        return [
            'id'      => 'filterId',
            'user'    => 'filterUser',
            'title'   => 'filterTitle',
            'rating'  => 'filterRating',
            'comment' => 'filterComment'
        ];
    }

    protected function allowed(): array {
        return array_keys($this->filters());
    }

    protected function filterId($value) {
        $this->builder->where('id', $value);
    }

    protected function filterUser($value) {
        $this->builder->where('user_id', $value);
    }

    protected function filterTitle($value) {
        $this->builder->where('title_id', $value);
    }

    protected function filterRating($value) {
        $this->builder->where('rating', $value);
    }

    protected function filterComment($value) {
        $this->builder->where('comment', 'LIKE', "%{$value}%");
    }

}
