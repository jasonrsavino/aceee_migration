<?php
 
namespace Drupal\aceee_migration\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * This plugin creates a new paragraph entity based on the source.
 *
 * @MigrateProcessPlugin(
 *   id = "gated_file"
 * )
 */
class GatedFile extends ProcessPluginBase {
  /**
   * The main function for the plugin, actually doing the data conversion.
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $field = 'field_report_number';

    if (!empty($row->getSourceProperty($field))) {
      if (is_string($report_number = $row->getSourceProperty($field)[0]['value'])) {
        return 1;
      }
    }

    return 0;
  }

}