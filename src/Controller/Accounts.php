<?php

namespace App\Controller;

class Accounts
{
    public function run()
    {
        $pdo = \App\Service\DB::get();
        $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `accounts`
            WHERE
                `id_user` = :id_user
        ");
        $stmt->execute([
            ':id_user' => $_SESSION['auth']['id']
        ]);

        $view = new \App\View\Accounts();
        $view->render([
            'data' => $stmt->fetchAll()
        ]);
    }

    public function runCreate()
    {
        if ($_POST && count($errors = $this->validateCreateAccount($_POST)) == 0) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                INSERT INTO
                    `accounts` (
                        `id_user`,
                        `login`,
                        `password`
                    ) VALUES (
                        :id_user,
                        :login,
                        :password
                    )
            ");
            $stmt->execute([
                ':id_user' => $_SESSION['auth']['id'],
                ':login' => $_POST['login'],
                ':password' => $_POST['password']
            ]);
            header('Location: /accounts');
            return;
        }

        $view = new \App\View\Accounts\Form();
        $view->render([
            'data' => $_POST,
            'errors' => $errors ?? []
        ]);
    }

    public function runUpdate()
    {
        if (isset($_GET['id'])) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                SELECT
                    *
                FROM
                    `accounts`
                WHERE
                    `id` = :id AND `id_user` = :id_user
            ");
            $stmt->execute([
                ':id' => $_GET['id'],
                ':id_user' => $_SESSION['auth']['id']
            ]);
            $account = $stmt->fetch();
        }

        if (! isset($account) || ! $account) {
            header('Location: /accounts');
            return;
        }

        if ($_POST) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                UPDATE
                    `accounts`
                SET
                    `login` = :login,
                    `password` = :password
                WHERE
                    `id` = :id AND `id_user` = :id_user
            ");
            $stmt->execute([
                ':login' => $_POST['login'],
                ':password' => $_POST['password'],
                ':id' => $_GET['id'],
                ':id_user' => $_SESSION['auth']['id']
            ]);

            header('Location: /accounts');
            return;
        }

        $view = new \App\View\Accounts\Form();
        $view->render([
            'data' => $account,
            'update' => $account['id']
        ]);
    }

    public function runDelete()
    {
        if (isset($_GET['id'])) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                DELETE FROM
                    `accounts`
                WHERE
                    `id` = :id AND `id_user` = :id_user
            ");
            $stmt->execute([
                ':id' => $_GET['id'],
                ':id_user' => $_SESSION['auth']['id']
            ]);
            $user = $stmt->fetch();
        }

        header('Location: /accounts');
    }

    private function validateCreateAccount($data)
    {
        $errors = [];
        if (! $this->validateLogin($data)) {
            $errors['login'] = 'Вы забыли ввести логин!';
        }

        if (! $this->validateEmptyPassword($data)) {
            $errors['password'] = 'Вы забыли ввести пароль!';
        }

        return $errors;
    }

    private function validateEmptyPassword($data)
    {
        return isset($data['password']) && $data['password'] !== '';
    }

    private function validateLogin($data)
    {
        return isset($data['login']) && mb_strlen($data['login']) > 3;
    }
}
