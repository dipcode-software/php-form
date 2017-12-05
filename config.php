<?php
namespace PHPForm;

class PHPFormConfig
{
    const MESSAGES_FILE_PATH = 'src/messages.php';
    const TEMPLATES_FILE_PATH = 'src/templates.php';

    private static $config = null;

    private $messages = null;
    private $templates = null;

    private function __construct()
    {
        $this->messages = include static::MESSAGES_FILE_PATH;
        $this->templates = include static::TEMPLATES_FILE_PATH;
    }

    public static function getInstance()
    {
        if (is_null(static::$config)) {
            static::$config = new PHPFormConfig();
        }

        return static::$config;
    }

    public static function getIMessage(string $id)
    {
        return static::getInstance()->getMessage($id);
    }

    public function getMessage(string $id)
    {

        return array_key_exists($id, $this->messages) ? $this->messages[$id] : null;
    }

    public static function getITemplate(string $id)
    {
        return static::getInstance()->getTemplate($id);
    }

    public function getTemplate(string $id)
    {
        return array_key_exists($id, $this->templates) ? $this->templates[$id] : null;
    }

    public function setMessages(array $messages)
    {
        $this->messages = array_merge($this->messages, $messages);
    }

    public function setTemplates(array $templates)
    {
        $this->templates = array_merge($this->templates, $templates);
    }
}
