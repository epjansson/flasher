<?php

class FlasherTest extends PHPUnit_Framework_TestCase
{

    protected $flasher;
    protected $di;
    protected $config = [];

    public function setUp()
    {
        $this->flasher = new Epj\Flasher();
        $this->di = new Anax\DI\CDIFactoryDefault();
        $this->flasher->setDI($this->di);

        $this->di->setShared('session', function () {
            $session = new Anax\Session\CSession();
            $session->configure(ANAX_APP_PATH . 'config/session.php');
            $session->name();
            //$session->start();
            return $session;
        });
        $types = [
            "success" => [
                "css_class" => "Flash Flash--success",
                "icon" => "fa-success",
                "title" => "Success!"
            ],
            "notice" => [
                "css_class" => "Flash Flash--notice",
                "icon" => "fa-notice",
                "title" => "Notice"
            ]
        ];

        $templates = [
            "default" => "flasher/default",
            "with_icon" => "flasher/with-icon"
        ];

        $this->config["templates"] = $templates;
        $this->config["types"] = $types;
    }

    public function testSetOptions()
    {
        $this->flasher->setOptions($this->config);

        $getTypes = $this->flasher->getTypes();

        $getTemplates = $this->flasher->getTemplates();

        $this->assertEquals($this->config["types"], $getTypes);
        $this->assertEquals($this->config["templates"], $getTemplates);
    }

    public function testSetOptionsWithEmptyArray()
    {
        $expectedTypes = [];
        $expectedTemplates = [
            'default' => null,
            'with_icon' => null
        ];

        $this->flasher->setOptions([]);

        $getTypes = $this->flasher->getTypes();
        $getTemplates = $this->flasher->getTemplates();

        $this->assertEquals($expectedTypes, $getTypes);
        $this->assertEquals($expectedTemplates, $getTemplates);
    }

    public function testIfFlashMessageIsInSession()
    {
        $this->flasher->setOptions($this->config);

        $this->flasher->success("This is a flash message with the type: success");
        $this->flasher->notice("This is another flash message with the type: success");

        $inSession = $this->di->session->get("flasher");

        $this->assertCount(2, $inSession);
    }

    /**
     * @expectedException Anax\Exception\ForbiddenException
     */
    public function testIfFlashMessageIsNotAllowed()
    {
        $this->flasher->setOptions($this->config);

        $this->flasher->sucsscess("This is a flash message with the type: success");
        
    }

    public function testIfFlashMessageIsSentToView()
    {
        $this->flasher->setOptions($this->config);

        $this->flasher->success("This is a test");

        $this->assertCount(1, $this->di->session->get("flasher"));

        $this->flasher->get();

        $inSession = $this->flasher->get("flasher");

        $isSentToView = $this->di->views->hasContent("flash_message");

        $this->assertTrue($isSentToView);
        $this->assertNull($inSession);
    }
}
