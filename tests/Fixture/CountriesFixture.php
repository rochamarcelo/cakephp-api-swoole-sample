<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CountriesFixture
 */
class CountriesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'code' => 'Lo',
                'name' => 'Lorem ipsum dolor sit amet',
                'native' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum d',
                'continent' => 'Lo',
                'capital' => 'Lorem ipsum dolor sit amet',
                'currency' => 'Lorem ipsum dolor sit amet',
                'languages' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
