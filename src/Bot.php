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
    public $_username = 'SlackBOT';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->channel === null || $this->token === null) {
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
        return $this->message($message, $options = []);
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
        return $this->message($message, $options);
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
        return $this->message($message, $options);
    }

    /**
     * 
     * @param string $message
     * @param array $options
     * @return \kostikpenzin\SlackBot\Bot
     */
    public function message($message, array $options = [])
    {
        $options['text'] = $message;
        return $this;
    }

    /**
     * 
     * @return boolean
     */
    public function send()
    {
        return $this->parseAndSend($data);
    }

    /**
     * 
     * @return boolean
     */
    private function parseAndSend()
    {
        $curl = new Curl();
        $curl->post('https://slack.com/api/chat.postMessage', [
            'token' => $this->token,
            'channel' => $this->channel,
            'username' => $this->username,
            'attachments' => json_encode($attachements),
            'icon_emoji' => $this->icon
        ]);

        return $curl->isSuccess();
    }
}
