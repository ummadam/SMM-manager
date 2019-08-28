<?php

namespace App\View\Tasks;

class Form extends \App\View\Main
{
    public function content($data = [])
    {
        ?>
            <div class="block">
                <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button"><i class="si si-settings"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Static Labels</h3>
                </div>
                <div class="block-content block-content-narrow">
                    <form class="form-horizontal push-10-t" enctype="multipart/form-data" action="<?= isset($data['update']) ? '/tasks/update?id=' . $data['update'] : '/tasks/create' ?>" method="post">
                        <div class="form-group <?= isset($data['errors']['title']) ? 'has-error' : '' ?>">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="material-text" name="title" placeholder="Please enter your login" value="<?= $data['data']['login'] ?? '' ?>">
                                    <label for="material-text">Title</label>
                                    <?= isset($data['errors']['title']) ? '<div class="help-block text-right">' . $data['errors']['title'] . '</div>' : '' ?>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group <?= isset($data['errors']['description']) ? 'has-error' : '' ?>">
                            <div class="col-sm-9">
                                <div class="form-material">
                                <textarea class="form-control" id="material-textarea-large" name="description" rows="8" placeholder="Please add a comment"><?= $data['data']['description'] ?? '' ?></textarea>
                                    <label for="material-text">Description</label>
                                    <?= isset($data['errors']['title']) ? '<div class="help-block text-right">' . $data['errors']['title'] . '</div>' : '' ?>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group <?= isset($data['errors']['account']) ? 'has-error' : '' ?>">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <select class="form-control" id="material-select" name="id_account" size="1">
                                        <option>...</option>
                                        <?php 
                                            foreach($data['accounts'] as $account){
                                                echo '<option value =" ' . $account['id'] .'">' . $account['login']. '</option>';
                                            }
                                            ?>                                       
                                    </select>
                                    <label for="material-select">Account</label>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8">
                                <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true">
                                    <input class="form-control" type="text" id="example-datetimepicker7" name="publish_date" placeholder="Choose a date..">
                                    <label for="example-datetimepicker7">Publish date</label>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>                      
                        <div class="form-group">
                            <label class="col-xs-12" for="example-file-input">File Input</label>
                            <div class="col-xs-12">
                                <input type="file" id="example-file-input" name="image">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php
    }
}
