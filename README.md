# flasher: Flash messaging for Anax-MVC
Flasher is a PHP Class for handling flash messages in Anax-MVC.

Requirements
--
* PHP 5.4 or higher
* FontAwesome (optional)

Install
--
1. Copy "flasher_conf.php" in the config-folder to app/config. Edit the config file to suit your preferences.

2. Add flasher as a service in Anax-MVC

```php
// src/DI/CDIFactoryDefault.php
$this->setShared('flasher', function() {
    $flasher = new \Epj\Flasher\Flasher();
    $flasher->setOptions(require ANAX_APP_PATH . 'config/flasher_conf.php');
    $flasher->setDI($this);
    return $flasher;
});
```
3. Make sure session is started, otherwise start it!

4. Add flasher->get() at the top of the theme file or the frontcontroller you want to display flash messages.

```php
// In theme-file: at the top
$this->di->flasher->get();

// In a front-controller at the top
$app->flasher->get();
```

5. Add rendering of $flash_messages if it exists. Place it in the theme file where you want to render the flash message.

```php
if(isset($flash_message)) echo $flash_message;
$this->views->render('flash_message');
```

6. Done!

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
