<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'mvcex\\api\\lib\\apicontroller' => '/api/lib/APIController.php',
                'mvcex\\api\\lib\\apimodel' => '/api/lib/APIModel.php',
                'mvcex\\api\\lib\\apimodelcollection' => '/api/lib/APIModelCollection.php',
                'mvcex\\api\\lib\\apiresponse' => '/api/lib/APIResponse.php',
                'mvcex\\api\\lib\\dbconnector' => '/api/lib/DBConnector.php',
                'mvcex\\api\\lib\\validation\\filter' => '/api/lib/validation/Filter.php',
                'mvcex\\api\\lib\\validation\\required' => '/api/lib/validation/Required.php',
                'mvcex\\api\\lib\\validation\\validator' => '/api/lib/validation/Validator.php',
                'mvcex\\api\\routes\\logincontract' => '/api/routes/login/LoginContract.php',
                'mvcex\\api\\routes\\notfoundcontract' => '/api/routes/errors/NotFoundContract.php',
                'mvcex\\api\\services\\logincontroller' => '/api/services/auth/controller.php',
                'mvcex\\api\\services\\loginrequest' => '/api/services/auth/request.php',
                'mvcex\\api\\services\\loginresponse' => '/api/services/auth/response.php',
                'mvcex\\core\\database' => '/core/Database.php',
                'mvcex\\core\\model' => '/core/Model.php',
                'mvcex\\core\\query' => '/core/query.php',
                'mvcex\\core\\request' => '/core/request.php',
                'mvcex\\core\\response' => '/core/Response.php',
                'mvcex\\core\\routecontract' => '/core/RouteContract.php'
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
