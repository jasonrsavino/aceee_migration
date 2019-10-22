<?php

namespace Drupal\aceee_migration\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\node\Plugin\migrate\source\d7\Node as d7_node;

/**
 * Published news nodes from the d7 database.
 *
 * @MigrateSource(
 *   id = "aceee_publication_node",
 *   source_module = "node"
 * )
 */
class Publication extends d7_node {
    /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    return parent::prepareRow($row);
  }
}
