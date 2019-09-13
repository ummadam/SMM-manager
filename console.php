<?php

require 'vendor/autoload.php';

while(true){
    date_default_timezone_set('Asia/Almaty'); 
    $ig = new \InstagramAPI\Instagram(false, false, $storageConfig = []);
    
    $pdo = \App\Service\DB::get();
    $stmt = $pdo->prepare("
        SELECT
            `tasks`.*,
            `accounts`.`login`,
            `accounts`.`password`
        FROM
            `tasks`
        LEFT JOIN
            `accounts`
            ON
            `accounts`.`id` = `tasks`.`id_account`  
            WHERE `tasks`.`status` = 0   
        ");        
        
        $stmt->execute();
        $results = $stmt->fetchAll();
        
        $now = new DateTime("now");
        //echo $interval->days 
        
        //die();
        foreach($results as $task){
            $publishDate = new DateTime($task['publish_date']);
            $interval = $now->diff($publishDate);

            if($interval->days == 0){
                $filename = './uploads/' . sha1($task['id']) . '.jpeg';
                $metadata = [
                    'caption' => $task['description']
                ];
                $ig->login($task['login'], $task['password']);
                $ig->timeline->uploadPhoto($filename, $metadata);    
    
                $stmt = $pdo->prepare("
                    UPDATE
                        `tasks`
                    SET
                        `status` = 1
                    WHERE
                        `id` = :id
                ");         
                $stmt->execute([                
                    ':id' => $task['id'],
                    
                ]);

            }

    
    }
}




