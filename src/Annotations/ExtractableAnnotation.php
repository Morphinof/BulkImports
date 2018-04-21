<?php
/**
 * Created by PhpStorm.
 * User: Morphinof
 * Date: 14/01/2018
 * Time: 10:10
 */

namespace BulkImports\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class ExtractableAnnotation extends Annotation
{
    /** @var string $columnIndex */
    public $columnIndex = 0;

    /** @var string $columnName */
    public $columnName = null;
}