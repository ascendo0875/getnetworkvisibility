<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage FinnPartners
 * @since FinnPartners 1.0
 */

namespace FINNPartners\Theme\Api\AbstractClass;

use FpStructure\Controller\Api\AbstractApiController as EndpointController;

abstract class AbstractApiController extends EndpointController
{
    const FP_STRUCTURE_NAMESPACE = 'theme/v2';
    const API_QUERY_SEARCH = 'query-search';
    const API_QUERY_PAGE = 'qpage';

    /**
     * @param string $paramStructure
     */
    public function __construct(string $paramStructure)
    {
        parent::__construct($paramStructure);
    }
}