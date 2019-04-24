<?php

namespace Mageplaza\GiftCard\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '2.0.1', '<')) {
            if ($installer->tableExists('customer_entity')) { //add column to customer_entity
                $installer->getConnection()
                    ->addColumn(
                        $installer->getTable('customer_entity'),
                        'giftcard_balance',
                        [
                            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                            'length' => '12,4',
                            'comment' => 'giftcard_balance'
                        ]

                    );
            }

            if (!$installer->tableExists('giftcard_history')) {//create new table
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('giftcard_history')
                )
                    ->addColumn(
                        'history_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary' => true,
                        ]
                    )
                    ->addColumn(
                        'giftcard_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        [
                            'unsigned' => true,
                            'nullable' => false,

                        ],
                        'gift card id'
                    )
                    ->addColumn(
                        'customer_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        10,
                        [
                            'unsigned' => true,
                            'nullable' => false,
                        ]
                    )
                    ->addColumn(
                        'amount',
                        \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                        '12,4',
                        [],
                        'lượng amount bị thay đổi'
                    )
                    ->addColumn(
                        'action',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        null,
                        [

                        ],
                        'hành động thay đổi'
                    )
                    ->addColumn(
                        'action_time',
                        \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                        null,
                        [],
                        'thời gian diễn ra thay đổi'
                    )
                ;
                $installer->getConnection()->createTable($table);
            }

            if ($installer->tableExists('giftcard_history')) { //add foreign key
                $connection = $installer->getConnection();
                $connection->addForeignKey(
                    $installer->getFkName('giftcard_history', 'giftcard_id', 'mageplaza_giftcard_code', 'giftcard_id'),
                    $installer->getTable('giftcard_history'),
                    'giftcard_id',
                    $installer->getTable('mageplaza_giftcard_code'),
                    'giftcard_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                );
                $connection->addForeignKey(
                    $installer->getFkName('giftcard_history', 'customer_id', 'customer_entity', 'entity_id'),
                    $installer->getTable('giftcard_history'),
                    'customer_id',
                    $installer->getTable('customer_entity'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                );
            }
        }

        //modify giftcard_code table
        if (version_compare($context->getVersion(), '1.0.11', '<')) {
            if ($installer->tableExists('giftcard_code')) {

                $installer->getConnection()->changeColumn(
                    $installer->getTable('giftcard_code'),
                    'create_at',
                    'create_at',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,
                        'comment' => 'Create At'
                    ]
                );
            }
        }

        //modify giftcard_history table
        if (version_compare($context->getVersion(), '1.0.11', '<')) {
            if ($installer->tableExists('giftcard_history')) {

                $installer->getConnection()->changeColumn(
                    $installer->getTable('giftcard_history'),
                    'action_time',
                    'action_time',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                        'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,
                    ]
                );
            }
        }

        $installer->endSetup();
    }
}
