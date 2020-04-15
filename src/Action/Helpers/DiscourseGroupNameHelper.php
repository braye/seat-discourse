<?php

namespace Herpaderpaldent\Seat\SeatDiscourse\Helpers;

class DiscourseGroupNameHelper
{
    /**
     * Discourse doesn't accept names with anything other than letters, numbers, dashes, and underscores.
     */
    public static function format(string $name): string
    {
        // strip out common symbols that don't meet the Discourse critera
        // sorry brits/europeans, I don't have a GBP/Euro symbol on my keyboard so just don't do that
        $fmtName = studly_case(preg_replace('/(\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\+|\=|\{|\}|\[|\]|\/)+/', ' ', $name));

        // Discourse also doesn't allow the last symbol of a group name to be anything than a letter or number
        // lob anything else off
        // this has the potential to delete the whole string but if you make a group name consisting of all underscores you had it coming
        while(preg_match('/a-zA-Z0-9/', substr($fmtName, strlen($fmtName) - 1) === 1)){
            $fmtName = substr($fmtName, 0, strlen($fmtName) - 1);
        }

        return $fmtName;
    }
}
