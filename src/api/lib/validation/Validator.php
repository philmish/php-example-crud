<?php declare(strict_types=1);

namespace mvcex\api\lib;

use mvcex\api\lib\Filter;

final class Validator {
    private array $rules;

    public function __construct(array $rules)
    {
       $this->rules = $rules; 
    }

    private function parseRule(string $rule, string $mapKey, array &$map): void
    {
        $map[$mapKey] = [];
        $parts = explode("|", $rule);
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

    private function parseRules(): array
    {
        $filterMap = [];
        foreach($this->rules as $key => $rulePattern) {
           $this->parseRule($rulePattern, $key, $filterMap); 
        }

        return $filterMap;
    }

    public function run(array $data): array {
        $filterMap = $this->parseRules();
        $errors = [];
        foreach ($filterMap as $key => $filters) {
            foreach($filters as $filter) {
                $filter->runFilter($data, $errors);
            }
        }
        return $errors;
    }
}
