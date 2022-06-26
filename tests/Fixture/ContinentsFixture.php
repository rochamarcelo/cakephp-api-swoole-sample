<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ContinentsFixture
 */
class ContinentsFixture extends TestFixture
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
                'name' => 'Lorem ipsum d',
            ],
        ];
        parent::init();
    }
}
