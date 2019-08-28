<?php

namespace App\Controller;

class Users
{
    public function run()
    {
        $pdo = \App\Service\DB::get();
        $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `users`
        ");
        $stmt->execute();

        $view = new \App\View\Users();
        $view->render([
            'data' => $stmt->fetchAll()
        ]);
    }

    public function runCreate()
    {
        if ($_POST && count($errors = $this->validateCreateUser($_POST)) == 0) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                INSERT INTO
                    `users` (
                        `name`,
                        `email`,
                        `password`
                    ) VALUES (
                        :name,
                        :email,
                        :password
                    )
            ");
            $stmt->execute([
                ':name' => $_POST['name'],
                ':email' => $_POST['email'],
                ':password' => sha1($_POST['password'])
            ]);
            header('Location: /users');
            return;
        }

        $view = new \App\View\Users\Form();
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
                    `users`
                WHERE
                    `id` = :id
            ");
            $stmt->execute([
                ':id' => $_GET['id']
            ]);
            $user = $stmt->fetch();
        }

        if (! isset($user) || ! $user) {
            header('Location: /users');
            return;
        }

        if ($_POST) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                UPDATE
                    `users`
                SET
                    `name` = :name,
                    `email` = :email,
                    `password` = :password
                WHERE
                    `id` = :id
            ");
            $stmt->execute([
                ':name' => $_POST['name'],
                ':email' => $_POST['email'],
                ':password' => isset($_POST['password']) && $_POST['password'] ? sha1($_POST['password']) : $user['password'],
                ':id' => $_GET['id']
            ]);

            header('Location: /users');
            return;
        }

        $view = new \App\View\Users\Form();
        $view->render([
            'data' => $user,
            'update' => $user['id']
        ]);
    }

    public function runDelete()
    {
        if (isset($_GET['id'])) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                DELETE FROM
                    `users`
                WHERE
                    `id` = :id
            ");
            $stmt->execute([
                ':id' => $_GET['id']
            ]);
            $user = $stmt->fetch();
        }

        header('Location: /users');
    }

    private function validateCreateUser($data)
    {
        $errors = [];
        if (! $this->validateName($data)) {
            $errors['name'] = 'Вы забыли ввести имя!';
        }

        if (! $this->validateEmptyPassword($data)) {
            $errors['password'] = 'Вы забыли ввести пароль!';
        }

        if (! $this->validateConfirmPassword($data)) {
            $errors['confirm-password'] = 'Пароли не совпадают!';
        }
        return $errors;
    }

    private function validateConfirmPassword($data)
    {
        return isset($data['password'], $data['confirm-password'])
            && $data['password'] === $data['confirm-password'];
    }

    private function validateEmptyPassword($data)
    {
        return isset($data['password']) && $data['password'] !== '';
    }

    private function validateName($data)
    {
        return isset($data['name']) && mb_strlen($data['name']) > 3;
    }
}
