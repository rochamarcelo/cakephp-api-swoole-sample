<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LanguagesFixture
 */
class LanguagesFixture extends TestFixture
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
                'rtl' => 1,
            ],
        ];
        parent::init();
    }
}
