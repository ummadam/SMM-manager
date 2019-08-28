<?php

namespace App\View\Users;

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
                    <form class="form-horizontal push-10-t" action="<?= isset($data['update']) ? '/users/update?id=' . $data['update'] : '/users/create' ?>" method="post">
                        <div class="form-group <?= isset($data['errors']['name']) ? 'has-error' : '' ?>">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="material-text" name="name" placeholder="Please enter your username" value="<?= $data['data']['name'] ?? '' ?>">
                                    <label for="material-text">Username</label>
                                    <?= isset($data['errors']['name']) ? '<div class="help-block text-right">' . $data['errors']['name'] . '</div>' : '' ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group <?= isset($data['errors']['password']) ? 'has-error' : '' ?>">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="password" id="material-password" name="password" placeholder="Please enter your password">
                                    <label for="material-password">Password</label>
                                    <?= isset($data['errors']['password']) ? '<div class="help-block text-right">' . $data['errors']['password'] . '</div>' : '' ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group <?= isset($data['errors']['confirm-password']) ? 'has-error' : '' ?>">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="password" id="material-password" name="confirm-password" placeholder="Please enter your password">
                                    <label for="material-password">Confirm Password</label>
                                    <?= isset($data['errors']['confirm-password']) ? '<div class="help-block text-right">' . $data['errors']['confirm-password'] . '</div>' : '' ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group <?= isset($data['errors']['email']) ? 'has-error' : '' ?>">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="email" id="material-email" name="email" placeholder="Please enter your email" value="<?= $data['data']['email'] ?? '' ?>">
                                    <label for="material-email">Email</label>
                                    <?= isset($data['errors']['email']) ? '<div class="help-block text-right">' . $data['errors']['email'] . '</div>' : '' ?>
                                </div>
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
