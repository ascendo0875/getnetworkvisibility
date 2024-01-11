<?php

namespace FINNPartners\Theme\Block\Instance;

use FINNPartners\Theme\Block\Instance\Fields\CustomersFeaturedFields;
use FINNPartners\Theme\PostType\Instance\Customer;
use FINNPartners\Theme\PostType\Register\Customer as CustomerPostType;
use FINNPartners\Theme\Theme;
use WP_Query;
use WpAdvanceCustomFieldsExtend\AbstractClass\Block;
use WpAdvanceCustomFieldsExtend\Service\Media;
use WpAdvanceCustomFieldsExtend\Service\Post2PostHelper;
use WpAdvanceCustomFieldsExtend\Service\QueryHelper;

class CustomersFeatured extends Block
{

    /**
     * @var CustomersFeaturedFields
     */
    private $fields;

    /**
     * @var bool
     */
    private $sideImg = false;

    /**
     * @var Customer[]|false
     */
    private $customers = null;

    /**
     * @param int|false $postId
     * @param array $block
     * @param bool $isPreview
     * @return void
     */
    public function __construct($postId = false, array $block = [], bool $isPreview = false)
    {
        $this->setFields(new CustomersFeaturedFields($postId, !empty($block['id']) ? $block['id'] : false));

        parent::__construct($block);

        $this->setIsPreview($isPreview)->execute();
    }

    public function execute(): Block
    {
        $this->setSideImg(in_array('is-style-side-img', !empty($this->getCSSClasses()) ? $this->getCSSClasses() : []));

        if ($this->getFields()->isAddCta() && !$this->getFields()->getLinkCta()) {
            $this->getFields()->setLinkCta($this->getFields()->getCustomersLanding());
        }

        return parent::execute(); // TODO: Change the autogenerated stub
    }

    /**
     * @return CustomersFeaturedFields
     */
    public function getFields(): CustomersFeaturedFields
    {
        return $this->fields;
    }

    /**
     * @param CustomersFeaturedFields $fields
     * @return $this
     */
    protected function setFields(CustomersFeaturedFields $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function previewNotAvailableHTML(): void
    {
        if ($this->isPreview() && !$this->getCustomers()) {
            parent::previewNotAvailableHTML(); // TODO: Change the autogenerated stub
        }
    }

    /**
     * @return false|Customer[]
     */
    public function getCustomers()
    {
        if (is_null($this->customers)) {
            $customers = false;

            if ($this->getFields()->getDataSource()) {
                $queryHelper = new QueryHelper();
                $isQuery = false;

                switch ($this->getFields()->getDataSource()) {
                    case CustomersFeaturedFields::DATASOURCE_MANUAL_SELECTION_VALUE:
                        $isQuery = !empty($this->getFields()->getCustomers());

                        if ($isQuery) {
                            $queryHelper->setArgs([
                                'post_type' => [CustomerPostType::POST_TYPE],
                                'post_status' => ['publish'],
                                'posts_per_page' => count($this->getFields()->getCustomers()),
                                'fields' => 'ids',
                                'post__in' => $this->getFields()->getCustomers(),
                                'orderby' => ['post__in' => 'asc'],
                            ]);
                        }
                        break;
                    default:
                        $isQuery = true;
                        $queryHelper->setArgs([
                            'post_type' => [CustomerPostType::POST_TYPE],
                            'post_status' => ['publish'],
                            'post__not_in' => [$this->getFields()->getPostId()],
                            'posts_per_page' => $this->getFields()->getLimit(),
                            'fields' => 'ids',
                        ]);
                        break;
                }

                if ($isQuery) {
                    $customers = new WP_Query($queryHelper->getArgs());
                    $customers = $customers->have_posts() ? $customers->get_posts() : false;

                    if ($customers) {
                        foreach ($customers as &$customer) {
                            /** @var int $customer */
                            $customer = new Customer($customer);
                            /** @var Customer $customer */

                            if (($customer->getFields()->getThumbnail() instanceof Media)) {
                                $customer->getFields()->getThumbnail()->setCrop(Theme::IMAGE_SIZES['highlighted_resources_list']['name']);
                            }
                        }
                    }
                }
            }

            $this->setCustomers($customers);
        }

        return $this->customers;
    }

    /**
     * @param false|Customer[] $customers
     * @return CustomersFeatured
     */
    public function setCustomers($customers)
    {
        $this->customers = $customers;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSideImg(): bool
    {
        return $this->sideImg;
    }

    /**
     * @param bool $sideImg
     * @return CustomersFeatured
     */
    public function setSideImg(bool $sideImg): CustomersFeatured
    {
        $this->sideImg = $sideImg;
        return $this;
    }
}