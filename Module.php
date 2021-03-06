<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2017 Power Kernel
 */

namespace powerkernel\sms;

use Yii;

/**
 * sms module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'powerkernel\sms\controllers';
    public $defaultRoute = 'aws';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        //\Yii::configure($this, require(__DIR__ . '/config.php'));
        $this->registerTranslations();
        $this->registerMailer();
    }

    /**
     * Config Mailer for the Module
     */
    public function registerMailer()
    {
        Yii::$app->mailer->setViewPath($this->basePath . '/mail');
        Yii::$app->mailer->htmlLayout = '@common/mail/layouts/html';
        Yii::$app->mailer->textLayout = '@common/mail/layouts/text';
    }

    /**
     * Register translation for the Module
     */
    public function registerTranslations()
    {
        $class = 'common\components\MongoDbMessageSource';
        Yii::$app->i18n->translations['sms'] = [
            'class' => $class,
            'on missingTranslation' => function ($event) {
                $event->sender->handleMissingTranslation($event);
            },
        ];
    }

    /**
     * Translate message
     * @param $message
     * @param array $params
     * @param null $language
     * @return mixed
     */
    public static function t($message, $params = [], $language = null)
    {
        return Yii::$app->getModule('sms')->translate($message, $params, $language);
    }

    /**
     * Translate message
     * @param $message
     * @param array $params
     * @param null $language
     * @return mixed
     */
    public static function translate($message, $params = [], $language = null)
    {
        return Yii::t('sms', $message, $params, $language);
    }
}
