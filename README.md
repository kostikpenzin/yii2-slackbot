# Yii 2 SlackBot

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
