<?php
namespace App;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\AuthenticationException;
class UserStuff implements \Nette\Security\IAuthenticator {
    function saveUser(string $username, string $password) {
        $jsondata = file_get_contents(__DIR__.'/users.json');
        $jsondata = json_decode($jsondata);
        $jsondata[] = [
            'username' => $username,
            'password' => $password
        ];
        file_put_contents(__DIR__.'/users.json', json_encode($jsondata, JSON_PRETTY_PRINT));
    }
    function authenticate(array $credentials): IIdentity{
        $readdata = file_get_contents(__DIR__.'/users.json');
        $readdata = json_decode($readdata);
        [$username, $password] = $credentials;
        foreach ($readdata as $id => $user) {
            if (($user->username === $username) && ($user->password === $password)) {
                return new Identity($id, null, ["username" => $username]);
            }
        }
        var_dump($readdata);
        throw new AuthenticationException;
    }
}