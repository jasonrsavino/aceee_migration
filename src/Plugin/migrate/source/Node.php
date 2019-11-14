<?php
/**
 * @file
 * Contains \Drupal\aceee_migration\Plugin\migrate\source\Node.
 */
 
namespace Drupal\aceee_migration\Plugin\migrate\source;
 
use Drupal\migrate\Row;
use Drupal\node\Plugin\migrate\source\d7\Node as D7Node;

/**
 * Custom node source including url aliases.
 *
 * @MigrateSource(
 *   id = "aceee_migration_node",
 *   source_module = "node"
 * )
 */
class Node extends D7Node {

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return ['alias' => $this->t('Path alias')] + parent::fields();
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // Include path alias.
    $nid = $row->getSourceProperty('nid');
    $query = $this->select('url_alias', 'ua')
      ->fields('ua', ['alias']);
    $query->condition('ua.source', 'node/' . $nid);
    $alias = $query->execute()->fetchField();
    if (!empty($alias)) {
      $row->setSourceProperty('alias', '/' . $alias);
    }
    return parent::prepareRow($row);
  }

}