# Yii 2 SlackBot

[![Latest Stable Version](https://poser.pugx.org/kostikpenzin/yii2-slackbot/v/stable)](https://packagist.org/packages/kostikpenzin/yii2-slackbot)
[![Total Downloads](https://poser.pugx.org/kostikpenzin/yii2-slackbot/downloads)](https://packagist.org/packages/kostikpenzin/yii2-slackbot)
[![Latest Unstable Version](https://poser.pugx.org/kostikpenzin/yii2-slackbot/v/unstable)](https://packagist.org/packages/kostikpenzin/yii2-slackbot)
[![License](https://poser.pugx.org/kostikpenzin/yii2-slackbot/license)](https://packagist.org/packages/kostikpenzin/yii2-slackbot)
[![Monthly Downloads](https://poser.pugx.org/kostikpenzin/yii2-slackbot/d/monthly)](https://packagist.org/packages/kostikpenzin/yii2-slackbot)

Yii bot for sending messages (alerts) to Slack.

## Setup

Add the `kostikpenzin/yii2-slackbot` package to your composer.json

```sh
composer require kostikpenzin/yii2-slackbot
```

Add the component to your config in the components section:

```php
'components' => [
    // ...
    'slackbot' => [
        'class' => 'kostikpenzin\SlackBot\Bot',
        '_token' => 'Asdw-111111111-2222222222-3333333333',
        '_channel' => 'Finanso_alert',
        '_username' => 'SlackBot',
        '_icon' => ''
    ]
]
```

Using in your Application:

```php
\Yii::$app->slackbot->message('Message.')->send();
```
