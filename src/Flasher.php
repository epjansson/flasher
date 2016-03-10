<?php namespace Epj;

class Flasher implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectionAware;

    // Array to store all the flash message types with all its options.
    protected $types = [];

    // Array to store the usable templates.
    protected $templates = [];

    /**
     * Handle the flash-message if it exists in the config.
     *
     * @param array $args
     *
     * @return void
     */
    public function __call($name, $args)
    {
        // Check if the called function exists in $this->types, if so; add the message to the session
        if (array_key_exists($name, $this->types) && is_string($args[0])) {
            $message = $args[0];
            $options = $this->types[$name];
            $view = $this->getTemplateForFlashType($this->types[$name]);
            $this->add($message, $options, $view);
        } else {
            throw new \Anax\Exception\ForbiddenException("You are trying to use a flash type that is not allowed.");
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

        $typeDefault = [
            "css_class" => "Flash",
            "icon"      => null,
            "title"     => null
        ];

        if (isset($options['types'])) {
            foreach ($options['types'] as $key => $value) {
                $merge = array_merge($typeDefault, $value);
                $this->types[$key] = $merge;
            }
        }

        $this->templates = !empty($options['templates']) ? array_merge($templates, $options['templates']) : $templates;
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
    protected function add($message, $options, $view)
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
        //Get the messages from the session
        $messages = $this->di->session->get("flasher");

        // Return if there are no messages in the session
        if (is_null($messages)) {
            return;
        }

        // Add message(s) to a view.
        foreach ($messages as $message) {
            $this->addView((object)$message);
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
    protected function getTemplateForFlashType($options)
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
    protected function addView($message)
    {
        $this->di->views->add($message->view, [
            "flash" => $message
        ], "flash_message");
    }

    /**
     * Gets the value of types.
     *
     * @return mixed
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Gets the value of templates.
     *
     * @return mixed
     */
    public function getTemplates()
    {
        return $this->templates;
    }
}
