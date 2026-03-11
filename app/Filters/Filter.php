<?php

namespace App\Filters;

use \Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filter {
    protected $request;
    protected $builder;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Applies the request filters to the received Eloquent query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder  The base query.
     * @return \Illuminate\Database\Eloquent\Builder  The query with all filters applied.
     */
    public function apply(Builder $builder) {
        # Stores the query into the class object
        $this->builder = $builder;        

        # Retrieves the allowed parameters of the specific class
        $invalid = array_diff(array_keys($this->request->all()), $this->allowed());

        # Check if there are any invalid parameters
        if (!empty($invalid)) {
            $this->throwError('Invalid query parameter(s): ' . implode(', ', $invalid));
        }


        # Iterates over the filters
        foreach ($this->filters() as $name => $method) {
            # Checks if the request has this parameter
            if ($this->request->filled($name)) {
                # Retrieves the parameter value
                $value = $this->request->input($name);
                # Dynamically calls the corresponding filter method
                $this->$method($value);
            }
        }
        
        return $this->builder;
    }

    /**
     * Throws a default error for invalid parameters.
     * 
     * @param string $message
     * @param int $status
     */
    protected function throwError($message, $status = 400) {
        throw new HttpResponseException(
            response()->json([
                'error'   => true,
                'message' => $message
            ], $status)
        );
    }

    /**
     * Defines the filter/method mapping.
     *
     * @return array
     */
    abstract protected function filters(): array;

    /**
     * Defines the allowed filters in each model.
     *
     * @return array
     */    
    abstract protected function allowed(): array;
}