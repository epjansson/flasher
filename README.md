# flasher: Flash messaging for Anax-MVC
Flasher is a PHP Class for handling flash messages in Anax-MVC.

Requirements
--
* PHP 5.4 or higher
* FontAwesome (optional)

Install
--
1. Move/copy "config/flasher_conf.php" to app/config. Edit the config file to suit your preferences.

2. Move/copy files in "views"-folder to app/views/flasher.

3. Add flasher as a service in Anax-MVC

```php
// src/DI/CDIFactoryDefault.php
$this->setShared('flasher', function() {
    $flasher = new \Epj\Flasher();
    $flasher->setOptions(require ANAX_APP_PATH . 'config/flasher_conf.php');
    $flasher->setDI($this);
    return $flasher;
});
```
4. Make sure session is started, otherwise start it!

```php
// You can start session in webroot/config_with_app.php
$app->session();
```

5. Add flasher->get() at the top of the theme file or the frontcontroller you want to display flash messages.

```php
// In the theme-file...
$this->di->flasher->get();

// ...Or in a front-controller
$app->flasher->get();
```

6. Add rendering of $flash_messages if it exists. Place it in the theme file where you want to render the flash message.

```php
if(isset($flash_message)) echo $flash_message;
$this->views->render('flash_message');
```

7. Done!

Usage
--
#### Configuration
Set up the flash message types you want to use in the config file. You can choose any type you want as long as it follows the same pattern as the example configuration file.

#### Example
Flash a message of the type you specified in the config file. Example:
```php
$app->flasher->success("This is a flash message of the type 'success'");
```

License
--

This software is free software and carries a MIT license.
