<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   Sphinx Search Ultimate
 * @version   2.3.1
 * @revision  602
 * @copyright Copyright (C) 2013 Mirasvit (http://mirasvit.com/)
 */


/**
 * @category Mirasvit
 * @package  Mirasvit_SearchSphinx
 */
class Mirasvit_SearchSphinx_Model_Config
{
    const ENGINE_SPHINX          = 'sphinx';
    const ENGINE_SPHINX_EXTERNAL = 'sphinx_external';
    const ENGINE_FULLTEXT        = 'fulltext';

    const XML_PATH_SEARCH_ENGINE      = 'searchsphinx/general/search_engine';

    const XML_PATH_WILDCARD_EXCEPTION = 'searchsphinx/advanced/wildcard_exception';
    const XML_PATH_NOTWORDS           = 'searchsphinx/advanced/notword';
    const XML_PATH_REPLACE_WORD       = 'searchsphinx/advanced/replace_word';

    const XML_PATH_MATH_MODE          = 'searchsphinx/advanced/match_mode';
    const XML_PATH_RESULT_LIMIT       = 'searchsphinx/advanced/result_limit';
    const XML_PATH_SEARCH_TEMPLATE    = 'searchsphinx/advanced/search_template';

    const XML_PATH_WILDCARD           = 'searchsphinx/advanced/wildcard';

    public function getSearchEngine()
    {
        $engine = Mage::getStoreConfig(self::XML_PATH_SEARCH_ENGINE);
        if (!$engine) {
            return self::ENGINE_FULLTEXT;
        }

        return $engine;
    }

    public function getMatchMode()
    {
        return Mage::getStoreConfig(self::XML_PATH_MATH_MODE);
    }

    public function getResultLimit()
    {
        $limit = intval(Mage::getStoreConfig(self::XML_PATH_RESULT_LIMIT));
        if ($limit == 0) {
            $limit = 100000;
        }

        return $limit;
    }

    public function getSearchTemplate()
    {
        if (!Mage::getStoreConfig(self::XML_PATH_SEARCH_TEMPLATE)) {
            return 'and';
        }

        return Mage::getStoreConfig(self::XML_PATH_SEARCH_TEMPLATE);
    }

    public function isAllowedWildcard()
    {
        return (bool) Mage::getStoreConfig(self::XML_PATH_WILDCARD);
    }

    public function getWildcardExceptions()
    {
        $result = array();
        if (Mage::getStoreConfig(self::XML_PATH_WILDCARD_EXCEPTION)) {
            $exceptions = unserialize(Mage::getStoreConfig(self::XML_PATH_WILDCARD_EXCEPTION));
            foreach ($exceptions as $value) {
                $result[] = strtolower($value['word']);
            }
        }

        return $result;
    }

    public function getNotwords()
    {
        $result = array();
        if (Mage::getStoreConfig(self::XML_PATH_NOTWORDS)) {
            $exceptions = unserialize(Mage::getStoreConfig(self::XML_PATH_NOTWORDS));
            foreach ($exceptions as $value) {
                $result[] = strtolower($value['word']);
            }
        }

        return $result;
    }

    public function getReplaceWords()
    {
        $result = array();
        if (Mage::getStoreConfig(self::XML_PATH_REPLACE_WORD)) {
            $array = unserialize(Mage::getStoreConfig(self::XML_PATH_REPLACE_WORD));
            foreach ($array as $value) {
                $word     = strtolower($value['replace']);
                $synonyms = explode(',', $value['find']);

                foreach ($synonyms as $synonym) {
                    $synonym = strtolower(trim($synonym));
                    $result[$word][$synonym] = $synonym;
                }
            }
        }

        return $result;
    }
}