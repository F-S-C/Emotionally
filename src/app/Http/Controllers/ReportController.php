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


class ReportController extends Controller
{
    private const JOY_KEY = "joy";
    private const SADNESS_KEY = "sadness";
    private const DISGUST_KEY = "disgust";
    private const CONTEMPT_KEY = "contempt";
    private const ANGER_KEY = "anger";
    private const FEAR_KEY = "fear";
    private const SURPRISE_KEY = "surprise";
    private const VALENCE_KEY = "valence";
    private const ENGAGEMENT_KEY = "engagement";
    private const TIMESTAMP_KEY = "Timestamp";
    private const SMILE_KEY = "smile";
    private const INNER_BROW_RAISE_KEY = "innerBrowRaise";
    private const BROW_RAISE_KEY = "browRaise";
    private const BROW_FURROW_KEY = "browFurrow";
    private const NOSE_WRINKLE_KEY = "noseWrinkle";
    private const UPPER_LIP_RAISE_KEY = "upperLipRaise";
    private const LIP_CORNER_DEPRESSOR_KEY = "lipCornerDepressor";
    private const CHIN_RAISE_KEY = "chinRaise";
    private const LIP_PUCKER_KEY = "lipPucker";
    private const LIP_PRESS_KEY = "lipPress";
    private const LIP_SUCK_KEY = "lipSuck";
    private const MOUTH_OPEN_KEY = "mouthOpen";
    private const SMIRK_KEY = "smirk";
    private const EYE_CLOSURE_KEY = "eyeClosure";
    private const ATTENTION_KEY = "attention";
    private const LID_TIGHTEN_KEY = "lidTighten";
    private const JAW_DROP_KEY = "jawDrop";
    private const DIMPLER_KEY = "dimpler";
    private const EYE_WIDEN_KEY = "eyeWiden";
    private const CHEEK_RAISE_KEY = "cheekRaise";
    private const LIP_STRETCH_KEY = "lipStretch";

    private const EMOJIS = [
        self::JOY_KEY => '&#x1F602;',
        self::SADNESS_KEY => '&#x1F622;',
        self::DISGUST_KEY => '&#x1F922;',
        self::CONTEMPT_KEY => '&#x1F928;',
        self::ANGER_KEY => '&#x1F621;',
        self::FEAR_KEY => '&#x1F628;',
        self::SURPRISE_KEY => '&#x1F62E;'
    ];

    public static function get_emoji($emotion)
    {
        return html_entity_decode(self::EMOJIS[$emotion]);
    }

    /**
     * Get the average report from a list of reports. If there's multiple
     * reports, the total average report must be generated using the
     * single average reports.
     * @param string|array ...$reports The reports.
     * @return array The average report.
     */
    public static function average(...$reports)
    {
        $average_report = [
            self::JOY_KEY => 0,
            self::SADNESS_KEY => 0,
            self::DISGUST_KEY => 0,
            self::CONTEMPT_KEY => 0,
            self::ANGER_KEY => 0,
            self::FEAR_KEY => 0,
            self::SURPRISE_KEY => 0,
            self::VALENCE_KEY => 0,
            self::ENGAGEMENT_KEY => 0,
            self::TIMESTAMP_KEY => 0,
            self::SMILE_KEY => 0,
            self::INNER_BROW_RAISE_KEY => 0,
            self::BROW_RAISE_KEY => 0,
            self::BROW_FURROW_KEY => 0,
            self::NOSE_WRINKLE_KEY => 0,
            self::UPPER_LIP_RAISE_KEY => 0,
            self::LIP_CORNER_DEPRESSOR_KEY => 0,
            self::CHIN_RAISE_KEY => 0,
            self::LIP_PUCKER_KEY => 0,
            self::LIP_PRESS_KEY => 0,
            self::LIP_SUCK_KEY => 0,
            self::MOUTH_OPEN_KEY => 0,
            self::SMIRK_KEY => 0,
            self::EYE_CLOSURE_KEY => 0,
            self::ATTENTION_KEY => 0,
            self::LID_TIGHTEN_KEY => 0,
            self::JAW_DROP_KEY => 0,
            self::DIMPLER_KEY => 0,
            self::EYE_WIDEN_KEY => 0,
            self::CHEEK_RAISE_KEY => 0,
            self::LIP_STRETCH_KEY => 0
        ];

        // Convert the reports to an array
        if (is_string($reports)) {
            $reports = json_decode($reports, true);
        } elseif (!is_array($reports)) {
            throw new \InvalidArgumentException("The input isn't a JSON string or an array");
        }

        // There are three scenarios:
        // 1. $reports is a single report object
        // 2. $reports is a array of single report object
        // 3. $reports is a array of arrays of single report object
        if (substr(json_encode($reports), 0, 1) == "{") {
            $type = 1;
        } elseif (substr(json_encode($reports), 0, 2) == "[[") {
            $type = 3;
        } else {
            $type = 2;
        }

        if ($type = 1) {
            $average_report = $reports;
        } elseif ($type = 2) {
            $number_of_frames = 0;
            foreach ($reports as $frame) {
                foreach ($average_report as $key => &$item) {
                    $item += $frame[$key];
                }
                $number_of_frames++;
            }

            foreach ($average_report as &$value) {
                if ($number_of_frames == 0) $value = 0;
                else $value /= $number_of_frames;
            }
        } else {
            foreach ($reports as &$array) {
                $array = self::average($array);
            }
            $average_report = self::average($reports);
        }

        return $average_report;
    }

    /**
     * Extract the emotion with the highest value from a list of reports.
     * @param string|array ...$reports The reports.
     * @return string The emotion with the highest value in the average report (derived from the given reports).
     */
    public static function highestEmotion(...$reports)
    {
        if (is_string($reports)) {
            $report = json_decode($reports, true);
        } elseif (!is_array($reports)) {
            throw new \InvalidArgumentException("The input isn't a JSON string or an array:" . json_encode($reports));
        }

        if (substr(json_encode($reports), 0, 1) == "{") {
            $reports = array($reports);
        }
        $totalAverageReport = sizeof($reports) > 1 ? self::average(...$reports) : $reports[0];

        $useful_values = [
            self::JOY_KEY => 0,
            self::SADNESS_KEY => 0,
            self::DISGUST_KEY => 0,
            self::CONTEMPT_KEY => 0,
            self::ANGER_KEY => 0,
            self::FEAR_KEY => 0,
            self::SURPRISE_KEY => 0
        ];
        foreach ($useful_values as $key => &$value) {
            $value = $totalAverageReport[$key] * 100;
        }
        return array_keys($useful_values, max($useful_values))[0];
    }

    /**
     * Get the emotion section from a report.
     * @param array|string $report The report.
     * @return array The emotions recorded in the report
     */
    public static function getEmotionValues($report)
    {
        if (is_string($report)) {
            $report = json_decode($report, true);
        } elseif (!is_array($report)) {
            throw new \InvalidArgumentException("The input isn't a JSON string or an array:" . json_encode($report));
        }

        if (substr(json_encode($report), 0, 1) == "{") {
            $report = array($report);
        }

        $final = array();
        foreach ($report as $single_report) {
            $useful_values = [
                self::JOY_KEY => 0,
                self::SADNESS_KEY => 0,
                self::DISGUST_KEY => 0,
                self::CONTEMPT_KEY => 0,
                self::ANGER_KEY => 0,
                self::FEAR_KEY => 0,
                self::SURPRISE_KEY => 0
            ];
            foreach ($useful_values as $key => &$value) {
                $value = $single_report[$key];
            }
            array_push($final, $useful_values);
        }
        return $final;
    }
}
