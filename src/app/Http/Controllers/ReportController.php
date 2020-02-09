<?php
/**
 * This file is part of Emotionally.
 *
 * Emotionally is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Emotionally is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Emotionally.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Emotionally\Http\Controllers;

use Emotionally\Project;
use Emotionally\User;
use Emotionally\Video;
use Illuminate\Http\Request;


class ReportController extends Controller
{
    /**
     * Get the average emotion from a report.
     * @param string|array $json The report
     * @return array
     */
    public function average($json)
    {
        $iterated = 0;
        $a = 0;
        $b = 0;
        $c = 0;
        $d = 0;
        $e = 0;
        $f = 0;
        $g = 0;
        foreach ($json as $row) {
            $a = $row['a'] + $a;
            $b = $row['a'] + $b;
            $c = $row['a'] + $c;
            $d = $row['a'] + $d;
            $e = $row['a'] + $e;
            $f = $row['a'] + $f;
            $g = $row['a'] + $g;
            $iterated++;
        }
        $averageReport = [
            'a' => $a / $iterated,
            'b' => $b / $iterated,
            'c' => $c / $iterated,
            'd' => $d / $iterated,
            'e' => $e / $iterated,
            'f' => $f / $iterated,
            'g' => $g / $iterated
        ];
        return $averageReport;
    }


}
