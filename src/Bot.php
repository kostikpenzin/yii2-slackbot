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
     * @param unknown $_message
     * @param array $_options
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function danger($_message, array $options = [])
    {
        $options['color'] = ArrayHelper::remove($_options, 'color', 'danger');
        return $this->message($_message, $_options = []);
    }

    /**
     * 
     * @param unknown $_message
     * @param array $_options
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function warning($_message, array $_options = [])
    {
        $options['color'] = ArrayHelper::remove($_options, 'color', 'warning');
        return $this->message($_message, $_options);
    }

    /**
     * 
     * @param unknown $message
     * @param array $options
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function success($_message, array $_options = [])
    {
        $options['color'] = ArrayHelper::remove($_options, 'color', 'good');
        return $this->message($_message, $_options);
    }

    private $_attachments = [];

    /**
     * 
     * @param string $_message
     * @param array $_options
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function message($_message, array $_options = [])
    {
        $_options['text'] = $_message;

        $this->_attachments[] = $_options;

        return $this;
    }

    /**
     * 
     * @return boolean
     */
    public function send()
    {
        $_data = $this->_attachments;
        $this->_attachments = [];

        return $this->_curlSend($_data);
    }

    /**
     * 
     * @param array $_att
     * @return boolean
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
