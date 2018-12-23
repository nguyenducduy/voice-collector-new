<?php
namespace Reward\Transformer;

use League\Fractal\TransformerAbstract;
use Moment\Moment;
use Reward\Model\Gift as GiftModel;
use Reward\Transformer\GiftStock as GiftStockTransformer;

class Gift extends TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = [
        'stocks'
    ];

    public function transform(GiftModel $gift)
    {
        $humandatecreated = new Moment($gift->datecreated);
        
        return [
            'id' => (string) $gift->id,
            'gtid' => (string) $gift->gtid,
            'name' => (string) $gift->name,
            'displayorder' => (string) $gift->displayorder,
            'datecreated' => (string) $gift->datecreated
        ];
    }

    public function includeStocks(GiftModel $gift)
    {
        $giftStokcs = $gift->getStocks();

        return $this->collection($giftStokcs, new GiftStockTransformer);
    }
}
