<?php
namespace KTU\AppBundle\Model;

use KTU\AppBundle\Entity\User;

class UserModel extends AbstractModel
{
    public function addAdmin($username, $email, $password)
    {
        $user     = new User();
        $salt     = md5(uniqid());
        $password = password_hash(
        $password,
            PASSWORD_BCRYPT,
            [
                'cost' => 12,
                'salt' => $salt
            ]
        );

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setSalt($salt);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_ADMIN']);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
    }
} 