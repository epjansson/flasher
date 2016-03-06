<?php namespace Epj;

class Flasher implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectionAware;

    // Array to store all the flash message types with all its options.
    private $types = [];

    // Array to store the usable templates.
    private $templates = [];

    /**
     * Handle the flash-message if it exists in the config.
     *
     * @param array $args
     *
     * @return void
     */
    public function __call($name, $args)
    {
        if (array_key_exists($name, $this->types) && is_string($args[0])) {
            $message = $args[0];
            $options = $this->types[$name];
            $view = $this->getTemplate($this->types[$name]);
            $this->add($message, $options, $view);
        } else {
            die("<strong>{$name}</strong> is not a valid flash message type. Make sure to add it in the config file if you want to use it!");
        }
    }

    /**
     * Set options from config file.
     *
     * @param array $options options array
     *
     * @return void
     */
    public function setOptions($options = null)
    {
        $templates = [
            'default' => null,
            'with_icon' => null
        ];

        $this->templates = !empty($options['template']) ? array_merge($templates, $options['template']) : false;

        $this->types = !empty($options['types']) ? $options['types'] : false;
    }

    /**
     * Set options from config file.
     *
     * @param string $message flash message
     * @param array $options flash message options
     * @param string $options view to render for the message
     *
     * @return void
     */
    private function add($message, $options, $view)
    {
        $options['message'] = $message;
        $options['view'] = $view;

        $_SESSION["flasher"][] = $options;
    }

    /**
     * Load the messages from session and send them to views.
     *
     * @return void
     */
    public function get()
    {
        $messages = $this->di->session->get("flasher");

        foreach ($messages as $message) {
            $this->display((object)$message);
        }

        unset($_SESSION['flasher']);
    }

    /**
     * Get the suitable template to render the message.
     *
     * @param array $options options array
     *
     * @return string
     */
    private function getTemplate($options)
    {
        if (is_null($this->templates)) {
            return 'flasher/default';
        }

        if (array_key_exists('icon', $options)) {
            $view = $this->templates['with_icon'];
        } else {
            $view = $this->templates['default'];
        }

        return $view;
    }

    /**
     * Add a view to render the message.
     *
     * @param object $message
     *
     * @return void
     */
    private function display($message)
    {
        $this->di->views->add($message->view, [
            "flash" => $message
        ], "flash_message");
    }
}
