<?php declare(strict_types=1);

use PDO;
use \mvcex\core\Request;

final class LoginRequest implements Request {
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password; 
    }

    public function passCorrect(string $passHash): bool {
        return password_verify($this->password, $passHash);
    }

    public function toQuery(): object
    {
        return function (PDO $db): array {
            $stmt = "SELECT name, password FROM Users WHERE email = ?";
            $args = [$this->email];
            $prep = $db->prepare($stmt);
            $prep->execute($args);
            return $prep->fetchAll(PDO::FETCH_ASSOC);
        }; 
    }

} 
