<?php

namespace Mageplaza\GiftCard\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('mageplaza_giftcard_code')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mageplaza_giftcard_code')
            )
                ->addColumn(
                    'giftcard_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Giftcard ID'
                )
                ->addColumn(
                    'code',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Giftcard Code'
                )
                ->addColumn(
                    'balance',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '12,4',
                    [],
                    'Giftcard Balance'
                )
                ->addColumn(
                    'amount_used',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '12,4',
                    ['nullable => true'],
                    'Giftcard Amount used'
                )
                ->addColumn(
                    'create_from',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    [],
                    'Giftcard Create from'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->setComment('Giftcard Table');
            $installer->getConnection()->createTable($table);

//            $installer->getConnection()->addIndex(
//                $installer->getTable('mageplaza_giftcard_code'),
//                $setup->getIdxName(
//                    $installer->getTable('mageplaza_giftcard_code'),
//                    ['code', 'balance', 'amount_used', 'create_from'],
//                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
//                ),
//                ['code', 'balance', 'amount_used', 'create_from'],
//                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
//            );
        }
        $installer->endSetup();
    }
}