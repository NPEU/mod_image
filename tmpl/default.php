<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_image
 *
 * @copyright   Copyright (C) NPEU 2019.
 * @license     MIT License; see LICENSE.md
 */

defined('_JEXEC') or die;

require_once dirname(__DIR__) . '/vendor/autoload.php';

use \Michelf\Markdown;

$hx       = $params->get('header_tag', 'h2');
$images   = $params->get('images', array());
$n_images = is_object($images) ? count(get_object_vars($images)) : 0;

if ($n_images == 0) {
    return;
}

$wrapper = 'div';
$has_details = false;
if (!empty($images->images0->caption) || !empty($images->images0->credit)) {
    $has_details = true;
    $wrapper = 'figure';
}

$container_classes = '';

if (isset($module->cover)) {
    $container_classes = 'u-image-cover  js-image-cover';
}

if (!empty($container_classes)) {
    $container_classes = ' class="' + $container_classes + '"';
}
?>
<?php if ($module->showtitle): ?>
<<?php echo $hx; ?>><?php echo $module->title; ?></<?php echo $hx; ?>>
<?php endif; ?>
<?php if($n_images > 1) : ?>
<!-- @TOTO -->
<?php else: /* @TODO - need to think about credit lines. */?>
<<?php echo $wrapper; echo $container_classes; ?> style="position: relative;">
    <?php if ($images->images0->url): ?><a href="<?php echo $images->images0->url; ?>"><?php endif; ?>
    <img src="<?php echo JURI::base() . $images->images0->image; ?>" width="600" alt="<?php echo $images->images0->alt; ?>">
    <?php if ($images->images0->url): ?></a><?php endif; ?>
    <?php if ($has_details): ?>
    <figcaption style="
        position: absolute;
        top: 0;
        background: rgba(0,0,0,0.5);
        color: #fff;
        padding: 0.5em;
    ">
        <details>
            <summary>Info</summary>
            <?php if (!empty($images->images0->caption)) : ?>
            <?php echo Markdown::defaultTransform($images->images0->caption); ?>
            <?php endif; ?>
            <?php if (!empty($images->images0->credit)) : ?>
            <?php echo Markdown::defaultTransform($images->images0->credit); ?>
            <?php endif; ?>
        </details>
    </figcaption>
    <?php endif; ?>
</<?php echo $wrapper; ?>>
<?php endif; ?>
