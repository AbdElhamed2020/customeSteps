<?php

namespace Subscription\Products\CustomerData\Subscription;

use Magento\Customer\CustomerData\SectionSourceInterface;


class Products extends \Magento\Framework\DataObject implements SectionSourceInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @var \Magento\Catalog\Block\Product\ListProduct
     */
    protected $listProductBlock;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Helper\Image                                  $imageHelper,
        \Magento\Catalog\Block\Product\ListProduct                     $listProductBlock,
        array                                                          $data = []
    )
    {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->imageHelper = $imageHelper;
        $this->listProductBlock = $listProductBlock;
        parent::__construct($data);
    }

    public function getSectionData()
    {

        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => 5])
            ->setPageSize(10)
            ->setCurPage(1);
        $productCollection = $collection;
        $data = [];
        foreach ($productCollection as $_product) {
            $data[] = [
                'product_id' => $_product->getId(),
                'name' => $_product->getName(),
                'price' => (float)$_product->getFinalPrice(),
                'image_url' => $this->getImageUrl($_product),
                'sku' => $_product->getSku(),
                'cart_url' => $this->getAddToCartPostParams($_product)
            ];
        }
        return [
            'subscribe_items' => $data
        ];
    }

    public function getImageUrl($_product)
    {
        $imageUrl = $this->imageHelper->init($_product, 'product_page_image_small')
            ->setImageFile($_product->getSmallImage()) // image,small_image,thumbnail
            ->resize(380)
            ->getUrl();

        return $imageUrl;
    }

    public function getAddToCartPostParams($product)
    {
        return $this->listProductBlock->getAddToCartPostParams($product);
    }

}
