<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'mvcex\\api\\lib\\apiresponse' => '/api/lib/response.php',
                'mvcex\\api\\lib\\basecollection' => '/api/lib/model.php',
                'mvcex\\api\\lib\\basemodel' => '/api/lib/model.php',
                'mvcex\\api\\lib\\controller' => '/api/lib/controller.php',
                'mvcex\\api\\lib\\dbconnector' => '/api/lib/database.php',
                'mvcex\\api\\lib\\filter' => '/api/lib/filter.php',
                'mvcex\\api\\lib\\required' => '/api/lib/filter.php',
                'mvcex\\api\\lib\\routecontract' => '/api/lib/route.php',
                'mvcex\\api\\lib\\validator' => '/api/lib/validator.php',
                'mvcex\\api\\routes\\logincontract' => '/api/services/login/contract.php',
                'mvcex\\api\\routes\\logincontroller' => '/api/services/login/controller.php',
                'mvcex\\api\\routes\\loginrequest' => '/api/services/login/request.php',
                'mvcex\\api\\routes\\loginresponse' => '/api/services/login/response.php',
                'mvcex\\api\\routes\\notfoundcontract' => '/api/services/NotFound/contract.php',
                'mvcex\\core\\database' => '/core/database.php',
                'mvcex\\core\\query' => '/core/query.php',
                'mvcex\\core\\request' => '/core/request.php',
                'mvcex\\core\\response' => '/core/response.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    },
    true,
    false
);
// @codeCoverageIgnoreEnd
