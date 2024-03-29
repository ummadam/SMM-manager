<?php

namespace App\Controller;

class Tasks
{
    public function run()
    {
        $pdo = \App\Service\DB::get();
        $stmt = $pdo->prepare("
            SELECT
                `tasks`.*,
                `accounts`.`login` 

            FROM
                `tasks`
            LEFT JOIN
                `accounts`
            ON `tasks`.`id_account` = `accounts`.`id`
            WHERE
                `tasks`.`id_user` = :id_user
        ");
        $stmt->execute([
            ':id_user' => $_SESSION['auth']['id']
        ]);

        $view = new \App\View\Tasks();
        $view->render([
            'data' => $stmt->fetchAll()
        ]);
    }

    public function runCreate()
    {
        if ($_POST && count($errors = $this->validateCreateTask($_POST)) == 0) {
            var_dump($_FILES);
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                INSERT INTO
                    `tasks` (
                        `id_account`,
                        `id_user`,
                        `title`,
                        `description`,
                        `publish_date`
                        
                    ) VALUES (
                        :id_account,
                        :id_user,
                        :title,
                        :description,
                        :publish_date
                    )
            ");
            $date = new \DateTime($_POST['publish_date']);
            
            $stmt->execute([
                ':id_account' => $_POST['id_account'],
                ':id_user' => $_SESSION['auth']['id'],
                ':title' => $_POST['title'],
                ':description' => $_POST['description'],
                ':publish_date' => $date->format('Y.m.d H:i:s')
                
            ]);

            $uploadFile = UPLOAD_DIR . sha1($pdo->lastInsertId()).'.jpeg';
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);


            header('Location: /tasks');
            return;
        }

        $view = new \App\View\Tasks\Form();
        $view->render([
            'data' => $_POST,
            'errors' => $errors ?? [],
            'accounts' => $this->getAccounts()
        ]);
    }

    public function getAccounts()
    {
        $pdo = \App\Service\DB::get();
        $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `accounts`
            WHERE `id_user` = :id_user
            ");
        
            $stmt->execute([
                ':id_user' => $_SESSION['auth']['id']
            ]);

            return $stmt->fetchAll();
    }

    public function runUpdate()
    {
        if (isset($_GET['id'])) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                SELECT
                    *
                FROM
                    `tasks`
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
            header('Location: /tasks');
            return;
        }

        if ($_POST) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                UPDATE
                    `tasks`
                SET
                    `id_account` = :id_account,                   
                    `title` = :title,
                    `description` = :description,
                    `publish_date` = :publish_date
                WHERE
                    `id` = :id AND `id_user` = :id_user
            ");
            $date = new \DateTime($_POST['publish_date']);
            $stmt->execute([                
                ':id' => $_GET['id'],
                ':id_user' => $_SESSION['auth']['id'],
                ':id_account' => $_POST['id_account'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'publish_date' => $date->format('Y.m.d H:i:s')
            ]);

            header('Location: /tasks');
            return;
        }

        $view = new \App\View\Tasks\Form();
        $view->render([
            'data' => $account,
            'update' => $account['id'],
            'accounts' => $this->getAccounts()
        ]);
    }

    public function runDelete()
    {
        if (isset($_GET['id'])) {
            $pdo = \App\Service\DB::get();
            $stmt = $pdo->prepare("
                DELETE FROM
                    `tasks`
                WHERE
                    `id` = :id AND `id_user` = :id_user
            ");
            $stmt->execute([
                ':id' => $_GET['id'],
                ':id_user' => $_SESSION['auth']['id']
            ]);
            $user = $stmt->fetch();
        }

        header('Location: /tasks');
    }

    private function validateCreateTask($data)
    {
        $errors = [];
        if (! $this->validateTitle($data)) {
            $errors['title'] = 'Вы забыли ввести название!';
        }

        if (! $this->validateAccount($data)) {
            $errors['account'] = 'У этого пользователя нет такого аккаунта!';
        }

       

        return $errors;
    }
    

    private function validateTitle($data)
    {
        return isset($data['title']) && mb_strlen($data['title']) > 3;
    }

    private function validateAccount($data)
    {
       $accounts = $this->getAccounts();
       $accountsIDs = [];
       foreach($accounts as $account){
           $accountsIDs[] = $account['id'];

       }
       return isset($data['id_account']) && in_array($data['id_account'],$accountsIDs);
    }
}
