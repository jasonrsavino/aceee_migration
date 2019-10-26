<?php

namespace Drupal\aceee_migration\Plugin\migrate\process;

use Drupal\media_entity\Entity\Media;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\MigrateException;
use Drupal\migrate\Row;
use Drupal\migrate_plus\Plugin\migrate\process\EntityGenerate;

/**
 * Generate a media entity with specified metadata.
 *
 * This plugin is to be used by migrations which have media entity reference
 * fields.
 *
 * Available configuration keys:
 * - destinationField: the name of the file field on the media entity.
 *
 * @code
 * process:
 *   'field_files/target_id':
 *     -
 *       plugin: migration
 *       source: files
 *     -
 *       plugin: media_generate
 *       destinationField: image
 *
 * @endcode
 *
 * @MigrateProcessPlugin(
 *   id = "media_generate"
 * )
 */
class MediaGenerate extends EntityGenerate {
  /**
  * {@inheritdoc}
  */
  public function transform($value, MigrateExecutableInterface $migrateExecutable, Row $row, $destinationProperty) {
    if (!isset($this->configuration['destinationField'])) {
      throw new MigrateException('Destination field must be set.');
    }

    $type = $this->configuration['bundle'];

    // First load the target_id of the file referenced via the migration.
    /* @var /Drupal/file/entity/File $file */
    $file = $this->entityManager->getStorage($type)->load($value);
    
    if (empty($file)) {
      throw new MigrateException('Referenced file does not exist');
    }
    
    // Creates a media entity if the lookup determines it doesn't exist.
    $fileName = $file->label();
    if (!($entityId = parent::transform($fileName, $migrateExecutable, $row, $destinationProperty))) {
      return NULL;
    }
    $entity = Media::load($entityId);
    
    $fileId = $file->id();
    $entity->{$this->configuration['destinationField']}->setValue($fileId);
    $entity->save();
    
    return $entityId;
  }

}