<?php declare(strict_types=1);

namespace mvcex\api\lib\validation;

use mvcex\api\lib\exceptions\InvalidInputs;

final class Validator {
    /**
     * Data validator for running validation filters on an array.
     *
     * @param array<string, string> $rules  Keys from the array to be validated with parseable array strings as values
     * @param string $delimiter = "|"  delimiter used to split a rule's filter
     */
    private array $rules;
    private string $delimiter;

    public function __construct(array $rules, string $delimiter="|")
    {
       $this->rules = $rules; 
       $this->delimiter = $delimiter;
    }

    /**
     * Parses a rule to a filter and pushes it under the key from the array to validate.
     *
     * @param string $rule  Rule string to parse
     * @param string $mapKey  Key to store the filter under and also the key to use the filter on
     * @param array<string, Filter> $map Array to save the filter to
     */
    private function parseRule(string $rule, string $mapKey, array &$map): void
    {
        $map[$mapKey] = [];
        $parts = explode($this->delimiter, $rule);
        foreach($parts as $part) {
            switch($part) {
            case 'required':
                array_push($map[$mapKey], new Required([$mapKey]));
                break;
            default:
                break;
            }
        }
    } 

    /**
     * Parses all rules.
     *
     * @return array<string, array<int, Filter>> $filterMap Mapping from Keys to related Filter
     */
    private function parseRules(): array
    {
        $filterMap = [];
        foreach($this->rules as $key => $rulePattern) {
           $this->parseRule($rulePattern, $key, $filterMap); 
        }
        return $filterMap;
    }

    /**
     * Executes the array of filters parsed from the rules on a provieded array. 
     *
     * @param array<string, mixed> $data Data to validate
     * @return array<string> $errors Errors encountered while running filters
     */
    public function run(array $data): InvalidInputs|bool {
        $filterMap = $this->parseRules();
        $errors = [];
        foreach ($filterMap as $key => $filters) {
            foreach($filters as $filter) {
                $filter->runFilter($data, $errors);
            }
        }
        if (count($errors) === 0) {
            return true;
        }
        return new InvalidInputs("Invalid Inputs", $errors);
    }
}
