<?php

namespace Gaaarfild\LaravelNotifications;

use Illuminate\Support\Traits\Macroable;

/**
 * Class Notifications.
 */
class Notifications
{
    use Macroable;

    /**
     * Messages to set to next request.
     */
    private $messages = [];
    /**
     * Session key to store messages.
     *
     * @var string
     */
    private $session_key = 'laravel-notifications.messages';
    /**
     * Filtered messages to return.
     *
     * @var array
     */
    private $filtered = [];

    /**
     * Set new message for the next request.
     *
     * @param $message
     * @param string $type
     * @param string $group
     */
    public function add($message, $type, $group = '0')
    {
        $this->messages[] = ['message' => $message, 'type' => $type, 'group' => $group];
        session()->flash($this->session_key, $this->messages);
    }

    /**
     * Alias for adding an info type of alert
     *
     * @param $message
     * @param string $group
     */
    public function info($message, $group = '0')
    {
        $this->add($message, 'info', $group);
    }

    /**
     * Alias for adding an success type of alert
     *
     * @param $message
     * @param string $group
     */
    public function success($message, $group = '0')
    {
        $this->add($message, 'success', $group);
    }

    /**
     * Alias for adding an warning type of alert
     *
     * @param $message
     * @param string $group
     */
    public function warning($message, $group = '0')
    {
        $this->add($message, 'warning', $group);
    }

    /**
     * Alias for adding an danger type of alert
     *
     * @param $message
     * @param string $group
     */
    public function danger($message, $group = '0')
    {
        $this->add($message, 'danger', $group);
    }

    /**
     * Alias for adding an error type of alert
     * In bootstrap render will be changed to danger
     *
     * @param $message
     * @param string $group
     */
    public function error($message, $group = '0')
    {
        $this->add($message, 'error', $group);
    }

    /**
     * Get all messages.
     *
     * @return array
     */
    public function all()
    {
        $this->filtered = session($this->session_key, []);

        return $this;
    }

    /**
     * Filter messages by group.
     *
     * @param $group
     *
     * @return $this
     */
    public function byGroup($group)
    {
        $filtered_messages = $this->filterMessage('group', $group);

        $this->filtered = $filtered_messages;

        return $this;
    }

    /**
     * Filter messages by type.
     *
     * @param $type
     *
     * @return $this
     */
    public function byType($type)
    {
        $filtered_messages = $this->filterMessage('type', $type);

        $this->filtered = $filtered_messages;

        return $this;
    }

    /**
     * Return filtered messages.
     *
     * @return array
     */
    public function get()
    {
        return $this->filtered;
    }

    /**
     * Get first filtered message.
     *
     * @param array $default
     *
     * @return array
     */
    public function first($default = [])
    {
        return (count($this->filtered) != 0) ? $this->filtered[0] : $default;
    }

    /**
     * Count filtered messages amount.
     *
     * @return array
     */
    public function count()
    {
        return count($this->filtered);
    }

    /**
     * Check if messages exists.
     *
     * @return array
     */
    public function has()
    {
        return count($this->filtered) > 0;
    }

    /**
     * Format filtered messages to JSON.
     *
     * @return mixed
     */
    public function toJson()
    {
        return json_encode($this->filtered);
    }

    /**
     * Format filtered messages as Twitter Bootstrap alerts.
     *
     * @return string
     */
    public function toHTML($custom_template = null)
    {
        $custom_template = is_null($custom_template)
            ? 'laravel-notifications/' . config('laravel-notifications.view')
            : $custom_template;

        if (view()->exists($custom_template)) {

            return view($custom_template, ['messages' => $this->filtered])->render();
        } else {

            return view('laravel-notifications::bootstrap3', ['messages' => $this->filtered])->render();
        }
    }

    /**
     * Fallback method for bootstrap rendering.
     *
     * @return string
     * @deprecated Please use toHTML() method instead
     */
    public function toBootstrap()
    {
        return $this->toHTML('bootstrap3');
    }

    /**
     * Filter messages by param.
     *
     * @param $param
     * @param $value
     *
     * @return array
     */
    private function filterMessage($param, $value)
    {
        $messages = session($this->session_key, []);

        $filtered_messages = [];
        foreach ($messages as $message) {
            if ($message[$param] == $value) {
                $filtered_messages[] = $message;
            }
        }

        return $filtered_messages;
    }
}
