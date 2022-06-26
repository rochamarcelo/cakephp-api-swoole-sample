<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Country Entity
 *
 * @property string $code
 * @property string $name
 * @property string $native
 * @property string $phone
 * @property string $continent
 * @property string $capital
 * @property string $currency
 * @property string $languages
 */
class Country extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'code' => true,
        'name' => true,
        'native' => true,
        'phone' => true,
        'continent' => true,
        'capital' => true,
        'currency' => true,
        'languages' => true,
    ];
}
