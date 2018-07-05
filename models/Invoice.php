<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property string $from
 * @property string $where
 * @property string $recipient
 * @property int $status
 */
class Invoice extends \yii\db\ActiveRecord
{
    const STATUS_WAITING = 1;
    const STATUS_DELIVERED = 2;
    const STATUS_TRANSITED = 3;
    const STATUS_IN_WAREHOUSE = 4;
    const STATUS_RETURNED = 5;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from', 'where', 'recipient', 'status'], 'required'],
            [['status'], 'integer'],
            [['from', 'where', 'recipient'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'Откуда',
            'where' => 'Куда',
            'recipient' => 'Получатель',
            'status' => 'Статус',
        ];
    }

    /**
     * Статусы
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_DELIVERED => 'Доставлен',
            self::STATUS_IN_WAREHOUSE => 'Принят на склад',
            self::STATUS_RETURNED => 'Возвращен',
            self::STATUS_TRANSITED => 'В пути',
            self::STATUS_WAITING => 'Ожидает отправки',
        ];
    }
}
