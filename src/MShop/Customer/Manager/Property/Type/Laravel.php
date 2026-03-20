<?php

declare (strict_types=1);
/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018-2026
 * @package MShop
 * @subpackage Customer
 */
namespace Aimeos\M_Shop\Customer\Manager\Property\Type;

/**
 * Laravel customer property type manager
 *
 * @package MShop
 * @subpackage Customer
 */
class Laravel extends \Aimeos\M_Shop\Customer\Manager\Property\Type\Standard
{
    /**
     * Returns a new manager for customer property type extensions
     *
     * @param string $manager Name of the sub manager type in lower case
     * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
     * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions, e.g Type, List's etc.
     */
    public function get_sub_manager(string $manager, ?string $name = null): \Aimeos\M_Shop\Common\Manager\Iface
    {
        return parent::get_sub_manager($manager, $name ?: 'Laravel');
    }
}