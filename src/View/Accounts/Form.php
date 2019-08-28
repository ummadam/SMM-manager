<?php

namespace App\View\Accounts;

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
                    <form class="form-horizontal push-10-t" action="<?= isset($data['update']) ? '/accounts/update?id=' . $data['update'] : '/accounts/create' ?>" method="post">
                        <div class="form-group <?= isset($data['errors']['login']) ? 'has-error' : '' ?>">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="material-text" name="login" placeholder="Please enter your login" value="<?= $data['data']['login'] ?? '' ?>">
                                    <label for="material-text">Login</label>
                                    <?= isset($data['errors']['login']) ? '<div class="help-block text-right">' . $data['errors']['login'] . '</div>' : '' ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group <?= isset($data['errors']['password']) ? 'has-error' : '' ?>">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="password" id="material-password" name="password" placeholder="Please enter your password" value="<?= $data['data']['password'] ?? '' ?>">
                                    <label for="material-password">Password</label>
                                    <?= isset($data['errors']['password']) ? '<div class="help-block text-right">' . $data['errors']['password'] . '</div>' : '' ?>
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
