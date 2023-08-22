<?php

namespace Drupal\sixteenth_cache_task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Cache\Cache;

/**
 * Returns responses for Sixteenth cache task routes.
 */
class SixteenthCacheTaskController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The cache service.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cache;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new SixteenthCacheTaskController object.
   *
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The cache service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The cache service.
   */
  public function __construct(CacheBackendInterface $cache, EntityTypeManagerInterface $entityTypeManager) {
    $this->cache = $cache;
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cache.default'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * Builds the response.
   */
  public function build($node) {
    $node = $this->entityTypeManager->getStorage('node')->load($node);
    // $nid = 130;
    $nid = $node->id();
    $cid = 'markseven:' . $nid;

    // Look for the item in cache so we don't have to do the work.
    if ($item = $this->cache->get($cid)) {
      return $item->data;
    }

    // Build up the markdown array we're going to use later.
    $node = Node::load($nid);
    $title = $node->getTitle();
    $markseven = [
      '#markup' => $title,
    ];

    // Set the cache so we don't need to do this work again until $node changes.
    $this->cache->set($cid, $markseven, Cache::PERMANENT, $node->getCacheTags());

    return $markseven;
  }

}
