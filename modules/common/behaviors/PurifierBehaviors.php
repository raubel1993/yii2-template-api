<?php

namespace common\behaviors;

use Yii;

class PurifierBehaviors extends \yii\base\Behavior
{
    public function events()
    {
        return [
            \yii\web\Application::EVENT_BEFORE_REQUEST => 'beforeRequest',
        ];
    }

    public function beforeRequest($event)
    {
        // Filtrar todo lo que se manda por Post
        $newPost = [];
        foreach (Yii::$app->request->bodyParams as $key => $param) {
            $newPost[$key] = self::purificar($param);
        }
        Yii::$app->request->setBodyParams($newPost);

        //Filtrar todo lo que se manda por Get
        $newGet = [];
        foreach (Yii::$app->request->queryParams as $key => $param) {
            $newGet[$key] = self::purificar($param);
        }
        Yii::$app->request->setQueryParams($newGet);

        return true;
    }

    public static function purificar($value)
    {
        if (is_string($value)) {
            return \yii\helpers\HtmlPurifier::process($value);
        } elseif (is_array($value)) {
            $newValue = [];
            foreach ($value as $key => $item) {
                $newValue[$key] = self::purificar($item);
            }
            return $newValue;
        }
        return $value;
    }
}
