<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RefreshTokensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RefreshTokensTable Test Case
 */
class RefreshTokensTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RefreshTokensTable
     */
    public $RefreshTokens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RefreshTokens',
        'app.AccessTokens'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RefreshTokens') ? [] : ['className' => RefreshTokensTable::class];
        $this->RefreshTokens = TableRegistry::getTableLocator()->get('RefreshTokens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RefreshTokens);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
