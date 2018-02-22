<?php
/*
 * citeproc-php
 *
 * @link        http://github.com/seboettg/citeproc-php for the source repository
 * @copyright   Copyright (c) 2016 Sebastian Böttger.
 * @license     https://opensource.org/licenses/MIT
 */

namespace Seboettg\CiteProc\Constraint;

use NumberFormatter;
use Seboettg\CiteProc\CiteProc;
use Seboettg\CiteProc\Util\NumberHelper;


/**
 * Class IsNumeric
 * @package Seboettg\CiteProc\Choose\Constraint
 *
 * @author Sebastian Böttger <seboettg@gmail.com>
 */
class IsNumeric implements ConstraintInterface
{

    private $isNumeric;

    public function __construct($value)
    {
        $this->isNumeric = $value;
    }

    /**
     * @param $value
     * @param int|null $citationNumber
     * @return bool
     */
    public function validate($value, $citationNumber = null)
    {
        if (isset($value->{$this->isNumeric})) {
            return $this->parseValue($value->{$this->isNumeric});
        }

        return false;
    }

    /**
     * Tests whether the given variables (Appendix IV - Variables) contain numeric content. Content is considered
     * numeric if it solely consists of numbers. Numbers may have prefixes and suffixes (“D2”, “2b”, “L2d”), and may be
     * separated by a comma, hyphen, or ampersand, with or without spaces (“2, 3”, “2-4”, “2 & 4”). For example, “2nd”
     * tests “true” whereas “second” and “2nd edition” test “false”.
     *
     * @param $evalValue
     * @return bool
     */
    private function parseValue($evalValue)
    {
        if (is_numeric($evalValue)) {
            return true;
        } else if (preg_match(NumberHelper::PATTERN_ORDINAL, $evalValue)) {
            $numberFormatter = new NumberFormatter(CiteProc::getContext()->getLocale()->getLanguage(), NumberFormatter::ORDINAL);
            return $numberFormatter->parse($evalValue) !== false;
        } else if (preg_match(NumberHelper::PATTERN_ROMAN, $evalValue)) {
            return NumberHelper::roman2Dec($evalValue) !== false;
        } else if (preg_match(NumberHelper::PATTERN_COMMA_AMPERSAND_RANGE, $evalValue)) {
            return true;
        }
        return false;
    }
}