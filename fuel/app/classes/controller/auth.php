<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bommortal
 * Date: 1/30/14 AD
 * Time: 5:05 PM
 * To change this template use File | Settings | File Templates.
 */

class Controller_auth extends Controller {

    public function before()
    {
        parent::before();
    }

    public function action_oauth($provider = null)
    {
        // bail out if we don't have an OAuth provider to call
        if ($provider === null)
        {
            \Response::redirect_back();
        }

        // load Opauth, it will load the provider strategy and redirect to the provider
        \Auth_Opauth::forge();
    }


    public function action_callback()
    {
        // Opauth can throw all kinds of nasty bits, so be prepared
        try
        {
            // get the Opauth object
            $opauth = \Auth_Opauth::forge(false);

            // and process the callback
            $status = $opauth->login_or_register();

            // fetch the provider name from the opauth response so we can display a message
            $provider = $opauth->get('auth.provider', '?');

            // deal with the result of the callback process
            switch ($status)
            {
                // a local user was logged-in, the provider has been linked to this user
                case 'linked':
                    // inform the user the link was succesfully made
                    \Messages::success(sprintf(__('login.provider-linked'), ucfirst($provider)));
                    // and set the redirect url for this status
                    $url = 'dashboard';
                    break;

                // the provider was known and linked, the linked account as logged-in
                case 'logged_in':
                    // inform the user the login using the provider was succesful
                    \Messages::success(sprintf(__('login.logged_in_using_provider'), ucfirst($provider)));
                    // and set the redirect url for this status
                    $url = 'dashboard';
                    break;

                // we don't know this provider login, ask the user to create a local account first
                case 'register':
                    // inform the user the login using the provider was succesful, but we need a local account to continue
                    \Messages::info(sprintf(__('login.register-first'), ucfirst($provider)));
                    // and set the redirect url for this status
                    $url = 'user/register';

                    break;

                // we didn't know this provider login, but enough info was returned to auto-register the user
                case 'registered':
                    // inform the user the login using the provider was succesful, and we created a local account
                    \Messages::success(__('login.auto-registered'));
                    // and set the redirect url for this status
                    $url = 'dashboard';
                    break;

                default:
                    throw new \FuelException('Auth_Opauth::login_or_register() has come up with a result that we dont know how to handle.');
            }

            $url = str_replace('#_=_','',$url);

            // redirect to the url set
            \Response::redirect($url);
        }

            // deal with Opauth exceptions
        catch (\OpauthException $e)
        {
            \Messages::error($e->getMessage());
            \Response::redirect_back();
        }

            // catch a user cancelling the authentication attempt (some providers allow that)
        catch (\OpauthCancelException $e)
        {
            // you should probably do something a bit more clean here...
            exit('It looks like you canceled your authorisation.'.\Html::anchor('users/oath/'.$provider, 'Click here').' to try again.');
        }

    }

    public function action_index()
    {

        echo View::forge('login/index');
        exit;
    }

}