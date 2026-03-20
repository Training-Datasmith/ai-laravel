<?php

declare (strict_types=1);
/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2026
 * @package MShop
 * @subpackage Customer
 */
namespace Aimeos\M_Shop\Customer\Manager\Address;

/**
 * Laravel implementation of the customer address class.
 *
 * @package MShop
 * @subpackage Customer
 */
class Laravel extends \Aimeos\M_Shop\Customer\Manager\Address\Standard
{
    /**
     * Returns the attributes that can be used for searching.
     *
     * @param bool $withsub Return also attributes of sub-managers if true
     * @return \Aimeos\Base\Criteria\Attribute\Iface[] List of search attribute items
     */
    public function get_search_attributes(bool $withsub = true): array
    {
        return array_replace(parent::get_search_attributes($withsub), $this->create_attributes(['customer.address.id' => ['label' => 'Customer address ID', 'internalcode' => 'id', 'internaldeps' => ['LEFT JOIN "users_address" AS mcusad ON ( mcus."id" = mcusad."parentid" )'], 'type' => 'int', 'public' => false]]));
    }
    /**
     * Returns the config path for retrieving the configuration values.
     *
     * @return string Configuration path
     */
    protected function get_config_path(): string
    {
        return 'mshop/customer/manager/address/laravel/';
    }
    /**
     * Returns the name of the used table
     *
     * @return string Table name
     */
    protected function table(): string
    {
        return 'users_address';
    }
}