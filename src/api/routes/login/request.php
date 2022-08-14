<?php declare(strict_types=1);

namespace mvcex\api\routes;

use PDO;
use Closure;
use \mvcex\core\Request;

final class LoginRequest implements Request {
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password; 
    }

    public function getPass(): string {
        return $this->password;
    }

    public function toQuery(): Closure
    {
        return function (PDO $db): array {
            $stmt = "SELECT name, password FROM Users WHERE email = ?";
            $args = [$this->email];
            $prep = $db->prepare($stmt);
            $prep->execute($args);
            $res =$prep->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }; 
    }

} 
