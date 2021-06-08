<?php

namespace kostikpenzin\SlackBot;

use Curl\Curl;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Slack Bot Component.
 *
 * @author Konstantin Penzin <penzin85@gmail.com>
 * @link https://github.com/kostikpenzin/yii2-slackbot
 * @version v0.1.0
 */
class Bot extends Component
{
    /**
     * @var string
     */
    public $_channel = null;

    /**
     * @var string
     */
    public $_token = null;

    /**
     * @var string
     */
    public $_icon = ':mega:';

    /**
     * @var string
     */
    public $_username = 'SlackBot';


    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        if ($this->_channel === null || $this->_token === null) {
            throw new InvalidConfigException("The _channel and _token property is not defined in your configuration.");
        }
    }

    /**
     * _attachments
     *
     * @var array
     */
    private $_attachments = [];

    /**
     * message
     *
     * @param string $_message
     * @param array $_options
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function message(string $_message, array $_options = []): \kostikpenzin\SlackBot\Bot
    {
        $_options['text'] = $_message;
        $this->_attachments[] = $_options;
        return $this;
    }

    /**
     * send
     *
     */
    public function send()
    {
        $_data = $this->_attachments;
        $this->_attachments = [];
        return $this->_curlSend($_data);
    }


    /**
     * channel
     *
     * @param  string $channel
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function channel(string $channel): \kostikpenzin\SlackBot\Bot
    {
        $this->_channel = $channel;
        return $this;
    }

    /**
     * user
     *
     * @param  string $username
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function user(string $username): \kostikpenzin\SlackBot\Bot
    {
        $this->_username = $username;
        return $this;
    }

    /**
     * icon
     *
     * @param  string $icon
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function icon(string $icon): \kostikpenzin\SlackBot\Bot
    {
        $this->_icon = $icon;
        return $this;
    }

    /**
     * _curlSend
     *
     * @param array $_att
     */
    private function _curlSend(array $_att)
    {
        $curl = new Curl();
        $curl->post('https://slack.com/api/chat.postMessage', [
            'token' => $this->_token,
            'channel' => $this->_channel,
            'username' => $this->_username,
            'attachments' => json_encode($_att),
            'icon_emoji' => $this->_icon
        ]);
        return $curl->isSuccess();
    }
}
