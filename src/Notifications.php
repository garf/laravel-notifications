<?php

namespace Gaaarfild\LaravelNotifications;

use Illuminate\Support\Traits\Macroable;
use Session;

/**
 * Class Conf
 * @package Gaaarfild\LaravelConf
 */
class Notifications
{

    use Macroable;

    /**
     * Messages to set to next request
     */
    private $messages = [];
    /**
     * Session key to store messages
     *
     * @var string
     */
    private $session_key = 'laravel-notifications.messages';
    /**
     * Filtered messages to return
     *
     * @var array
     */
    private $filtered = [];

    /**
     * Create new instance of Notifications class
     */
    public function __construct() {}

    /**
     * Set new message for the next request
     *
     * @param $message
     * @param string $type
     * @param string $group
     */
    public function set($message, $type='info', $group='0')
    {
        $this->messages[] = array('message' => $message, 'type' => $type, 'group' => $group);
        Session::flash($this->session_key, $this->messages);
    }

    /**
     * Get all messages
     *
     * @return array
     */
    public function all()
    {
        $this->filtered = Session::get($this->session_key, []);
        return $this;
    }


    /**
     * Filter messages by group
     *
     * @param $group
     * @return $this
     */
    public function byGroup($group)
    {
        $messages = Session::get($this->session_key, []);

        $filtered_messages = [];
        foreach ($messages as $message) {
            if ($message['group'] == $group) {
                $filtered_messages[] = $message;
            }
        }

        $this->filtered = $filtered_messages;
        return $this;
    }

    /**
     * Filter messages by type
     *
     * @param $type
     * @return $this
     */
    public function byType($type)
    {
        $messages = Session::get($this->session_key, []);

        $filtered_messages = [];
        foreach ($messages as $message) {
            if ($message['type'] == $type) {
                $filtered_messages[] = $message;
            }
        }

        $this->filtered = $filtered_messages;

        return $this;
    }

    /**
     * Return filtered messages
     *
     * @return array
     */
    public function get()
    {
        return $this->filtered;
    }

    /**
     * Format filtered messages to JSON
     *
     * @return mixed
     */
    public function toJson()
    {
        return json_enccode($this->filtered);
    }

    /**
     * Format filtered messages as Twitter Bootstrap alerts
     *
     * @return string
     */
    public function toBootstrap()
    {
        $html = '';
        foreach ($this->filtered as $message) {
            $html .= '<div class="alert alert-' . $message['type'] . ' alert-dismissable" style="margin-bottom: 1px;">
                              <button type="button" tabindex="-1" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              ' . $message['message'] . '
                            </div>';
        }
        return $html;
    }
}
