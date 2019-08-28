<?php

namespace App\View;

class Login extends Base
{
    public function container($data = [])
    {
        ?>
            <!-- Login Content -->
            <div class="bg-white pulldown">
                <div class="content content-boxed overflow-hidden">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                            <div class="push-30-t push-50 animated fadeIn">
                                <!-- Login Title -->
                                <div class="text-center">
                                    <i class="fa fa-2x fa-circle-o-notch text-primary"></i>
                                    <p class="text-muted push-15-t">CG.Planner</p>
                                </div>
                                <!-- END Login Title -->

                                <!-- Login Form -->
                                <!-- jQuery Validation (.js-validation-login class is initialized in js/pages/base_pages_login.js) -->
                                <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <form class="js-validation-login form-horizontal push-30-t" action="/login" method="post">
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div class="form-material form-material-primary floating">
                                                <input class="form-control" type="text" id="login-username" name="email">
                                                <label for="login-username">Email</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div class="form-material form-material-primary floating">
                                                <input class="form-control" type="password" id="login-password" name="password">
                                                <label for="login-password">Пароль</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label class="css-input switch switch-sm switch-primary">
                                                <input type="checkbox" id="login-remember-me" name="login-remember-me"><span></span> Remember Me?
                                            </label>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="font-s13 text-right push-5-t">
                                                <a href="base_pages_reminder_v2.html">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group push-30-t">
                                        <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                            <button class="btn btn-sm btn-block btn-primary" type="submit">Войти</button>
                                        </div>
                                    </div>
                                </form>
                                <!-- END Login Form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Login Content -->

            <!-- Login Footer -->
            <div class="pulldown push-30-t text-center animated fadeInUp">
                <small class="text-muted"><span class="js-year-copy"></span> &copy; OneUI 3.4</small>
            </div>
            <!-- END Login Footer -->
        <?php
    }
}