# flasher: Flash messaging for Anax-MVC
Flasher is a PHP Class for handling flash messages in Anax-MVC.

Requirements
--
* PHP 5.4 or higher
* FontAwesome (optional)

Install
--
#### Step 1: Move/copy Files 
* Move/copy "config/flasher_conf.php" to app/config.
* Move/copy files in "views"-folder to app/views/flasher.

#### Step 2: Add flasher as a service in Anax-MVC
Place the following code in src/DI/CDIFactoryDefault.php:

```php
$this->setShared('flasher', function() {
$flasher = new \Epj\Flasher();
$flasher->setOptions(require ANAX_APP_PATH . 'config/flasher_conf.php');
$flasher->setDI($this);
return $flasher;
});
```

#### Step 3: Sessions
Make sure session is started, otherwise start it!
You can start it by placing the following code in webroot/config_with_app.php:

```php
// You can start session in webroot/config_with_app.php
$app->session();
```

#### Step 4: Catch messages from the session
Add the following code to the theme file:
Make sure it is placed at the top of the file.

```php
$this->di->flasher->get();
```

#### Step 5: Render the messages
Add the following code to the theme file where you want the flash message to be rendered.

```php
if(isset($flash_message)) echo $flash_message;
$this->views->render('flash_message');
```
#### Step 6: Done!

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
