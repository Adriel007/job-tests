<?php
namespace common\models;

class Apple extends \yii\db\ActiveRecord
{
    public $id;
    public $color;
    public $created_at;
    public $fallen_at;
    public $status;
    public $size;

    const STATUS_ON_TREE = 0;
    const STATUS_ON_GROUND = 1;
    const STATUS_ROTTEN = 2;

    public function __construct($color)
    {
        parent::__construct();
        $this->color = $color;
        $this->created_at = time();
        $this->status = self::STATUS_ON_TREE;
        $this->size = 1.0;
    }

    public function fallToGround()
    {
        if ($this->status === self::STATUS_ON_TREE) {
            $this->fallen_at = time();
            $this->status = self::STATUS_ON_GROUND;
        }
    }

    public function eat($percent)
    {
        if ($this->status === self::STATUS_ON_TREE) {
            throw new \Exception('Não é possível comer a maçã enquanto ela estiver no pé.');
        }

        if ($this->status === self::STATUS_ROTTEN) {
            throw new \Exception('Não é possível comer a maçã podre.');
        }

        $remainingSize = $this->size - ($percent / 100);

        if ($remainingSize <= 0) {
            $this->status = self::STATUS_ROTTEN;
            $this->size = 0;
        } else {
            $this->size = $remainingSize;
        }
    }

    public function isRotten()
    {
        if ($this->status === self::STATUS_ON_GROUND && time() - $this->fallen_at >= 5 * 3600) {
            $this->status = self::STATUS_ROTTEN;
            $this->size = 0;
        }

        return $this->status === self::STATUS_ROTTEN;
    }
}
