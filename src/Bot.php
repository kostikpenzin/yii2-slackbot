<?php

namespace kostikpenzin\SlackBot;

use Curl\Curl;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Slack Bot Component.
 * 
 * @author Konstantin Penzin <penzin85@gmail.com>
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
    public $_icon = '';

    /**
     * @var string
     */
    public $_username = 'SlackBot';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->_channel === null || $this->_token === null) {
            throw new InvalidConfigException("The _channel and _token property is not defined in your configuration.");
        }
    }

    /**
     * 
     * @param unknown $message
     * @param array $options
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function danger($message, array $options = [])
    {
        $options['color'] = ArrayHelper::remove($options, 'color', 'danger');
        return $this->_message($message, $options = []);
    }

    /**
     * 
     * @param unknown $message
     * @param array $options
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function warning($message, array $options = [])
    {
        $options['color'] = ArrayHelper::remove($options, 'color', 'warning');
        return $this->_message($message, $options);
    }

    /**
     * 
     * @param unknown $message
     * @param array $options
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function success($message, array $options = [])
    {
        $options['color'] = ArrayHelper::remove($options, 'color', 'good');
        return $this->_message($message, $options);
    }

    /**
     * 
     * @param string $_message
     * @param array $options
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function _message($_message, array $options = [])
    {
        $options['text'] = $_message;
        return $this;
    }

    /**
     * 
     * @return boolean
     */
    public function send()
    {
        return $this->curlSend($this->_message);
    }

    /**
     * 
     * @return boolean
     */
    private function curlSend()
    {
        $curl = new Curl();
        $curl->post('https://slack.com/api/chat.postMessage', [
            'token' => $this->_token,
            'channel' => $this->_channel,
            'username' => $this->_username,
            'icon_emoji' => $this->_icon
        ]);

        return $curl->isSuccess();
    }
}
