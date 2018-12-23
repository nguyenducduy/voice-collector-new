<?php
namespace Reward\Transformer;

use League\Fractal\TransformerAbstract;
use Moment\Moment;
use Reward\Model\GiftType as GiftTypeModel;
use Reward\Model\Gift as GiftModel;
use Reward\Transformer\GiftAttribute as GiftAttributeTransformer;

class GiftType extends TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = [
        'attributes'
    ];

    public function transform(GiftTypeModel $gifttype)
    {
        $humandatecreated = new Moment($gifttype->datecreated);
        $myTotalGift = GiftModel::count([
            'gtid = :gtid:',
            'bind' => [
                'gtid' => $gifttype->id
            ]
        ]);
        return [
            'id' => (string) $gifttype->id,
            'name' => (string) $gifttype->name,
            'status' =>  [
                'label' => (string) $gifttype->getStatusName(),
                'value' => (string) $gifttype->status,
                'style' => (string) $gifttype->getStatusStyle()
            ],
            'total' => $myTotalGift,
            'datecreated' => (string) $gifttype->datecreated,
            'humandatecreated' => (string) $humandatecreated->format('d-m-Y, H:i')
        ];
    }

    public function includeAttributes(GiftTypeModel $gifttype)
    {
        $giftAttributes = $gifttype->getAttributes(['order' => 'id asc']);

        return $this->collection($giftAttributes, new GiftAttributeTransformer);
    }
}
