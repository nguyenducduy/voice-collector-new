<?php
namespace Reward\Model;

use Core\Model\AbstractModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Core\Helper\Utils as Helper;
use Gift\Model\GiftStock as GiftStockModel;

/**
 * @Source('fly_gift');
 * @Behavior('\Shirou\Behavior\Model\Timestampable');
 * @HasMany('id', '\Reward\Model\GiftStock', 'gid', {'alias': 'stocks'})
 */
class Gift extends AbstractModel
{
    /**
    * @Column(type="integer", nullable=true, column="rc_id")
    */
    public $rcid;

    /**
    * @Column(type="integer", nullable=true, column="gt_id")
    */
    public $gtid;

    /**
    * @Primary
    * @Identity
    * @Column(type="integer", nullable=false, column="g_id")
    */
    public $id;

    /**
    * @Column(type="string", nullable=true, column="g_name")
    */
    public $name;

    /**
    * @Column(type="integer", nullable=true, column="g_display_order")
    */
    public $displayorder;

    /**
    * @Column(type="integer", nullable=true, column="g_status")
    */
    public $status;

    /**
    * @Column(type="integer", nullable=true, column="g_date_created")
    */
    public $datecreated;

    /**
    * @Column(type="integer", nullable=true, column="g_date_modified")
    */
    public $datemodified;

    /**
    * @Column(type="integer", nullable=true, column="g_date_used")
    */
    public $dateused;

    const STATUS_AVAILABLE = 1;
    const STATUS_DELIVERED = 3;
    const STATUS_PENDING_DELIVERY = 5;

    public function validation()
    {
        $validator = new Validation();

        $validator->add('name', new PresenceOf([
            'message' => 'message-name-notempty'
        ]));

        $validator->add('gtid', new PresenceOf([
            'message' => 'message-gtid-notempty'
        ]));

        $validator->add('rcid', new PresenceOf([
            'message' => 'message-rcid-notempty'
        ]));

        return $this->validate($validator);
    }

    public function getCoverPath(): string
    {
        $config = $this->getDI()->get('config');
        $url = $this->getDI()->get('url');

        if ($this->cover != '') {
            return Helper::getFileUrl(
                $url->getBaseUri(),
                $config->default->rewards->directory,
                $this->cover
            );
        } else {
            return '';
        }
    }

    // public function afterDelete()
    // {
    //     return $this->getStocks()->delete();
    // }
}
