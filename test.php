<?php

require 'vendor/autoload.php';
while(true){
        $ig = new \InstagramAPI\Instagram(false, false, $storageConfig = []);
        $ig->login('digitaltrade.kz', '0yU83srAdiGI');

        $rankToken = \InstagramAPI\Signatures::generateUUID();

        $userId = $ig->people->getUserIdForName('digitaltrade.kz');
        $followers = $ig->people->getFollowers($userId, $rankToken);

        $followers = json_encode($followers);
        $followers = json_decode($followers, true);
        $followerIds = [];
        foreach($followers as $follower){
            foreach($follower as $key => $user){
                $followerIds[] = $user['pk'];
            }
        }


        $followings = $ig->people->getFollowing($userId, $rankToken);
        $followings = json_encode($followings);
        $followings = json_decode($followings, true);
        $followingIds = [];
        foreach($followings as $following){
            foreach($following as $key => $user){
                $followingIds[] = $user['pk'];
            }
        }
        //print_r($followingIds);
        //$unfollowIds = array_diff($followingIds, $followerIds);
        $unfollowIds = [];
        for($j=0; $j<count($followingIds); $j++){
            if(!in_array($followingIds[$j],$followerIds)){
                $unfollowIds[] = $followingIds[$j];
            }
        }
        //print_r($followerIds);
        //print_r($unfollowIds);

        foreach($unfollowIds as $unfollowId){
            $ig->people->unfollow($unfollowId);

        }
        sleep(604800);
}
