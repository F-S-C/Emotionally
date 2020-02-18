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

use Emotionally\Http\Controllers\ReportFormatters\Presentations\ProjectPresentation;
use Emotionally\Http\Controllers\ReportFormatters\Presentations\VideoPresentation;
use Emotionally\Http\Controllers\ReportFormatters\Spreadsheets\ProjectSpreadsheet;
use Emotionally\Http\Controllers\ReportFormatters\Spreadsheets\VideoSpreadsheet;
use Emotionally\Project;
use Emotionally\Video;
use Symfony\Component\Console\Output\ConsoleOutput;

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

    private const __NO_REPORT__ = "__no_report__";

    private const EMOJIS = [
        self::JOY_KEY => '&#x1F602;',
        self::SADNESS_KEY => '&#x1F622;',
        self::DISGUST_KEY => '&#x1F922;',
        self::CONTEMPT_KEY => '&#x1F928;',
        self::ANGER_KEY => '&#x1F621;',
        self::FEAR_KEY => '&#x1F628;',
        self::SURPRISE_KEY => '&#x1F62E;',
        self::__NO_REPORT__ => '&#x2205;'
    ];

    public static function get_emoji($emotion)
    {
        return html_entity_decode(self::EMOJIS[$emotion]);
    }

    /**
     * Get the type of report.
     * @param array $report The report.
     * @return int There are three scenarios (the number determine the output of this function):
     * 1. $report is a single report object
     * 2. $report is a array of single report object
     * 3. $report is a array of arrays of single report object
     */
    private static function getReportType(array $report)
    {
        if (empty($report) || substr(json_encode($report), 0, 1) == "{") {
            $type = 1;
        } elseif (substr(json_encode($report), 0, 2) == "[[") {
            $type = 3;
        } else {
            $type = 2;
        }
        return $type;
    }

    /**
     * Check and fix the type of the report.
     * @param mixed &$report The report to be fixed and checked. Will be converted to an array.
     * @throws \InvalidArgumentException If the report is not a string or an array
     */
    private static function fixType(&$report)
    {
        if (is_string($report)) {
            $report = json_decode($report, true);
        } elseif (!is_array($report)) {
            throw new \InvalidArgumentException("The input isn't a JSON string or an array");
        }
    }

    /**
     * Get the average report from a list of reports. If there's multiple
     * reports, the total average report must be generated using the
     * single average reports.
     * @param string|array $reports The reports.
     * @return array The average report.
     */
    public static function average($reports)
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

        self::fixType($reports);

        $type = self::getReportType($reports);

        if ($type == 1 || empty($reports)) {
            $average_report = $reports;
        } elseif ($type == 2) {
            foreach ($reports as $frame) {
                self::fixType($frame);

                foreach ($average_report as $key => &$item) {
                    if (array_key_exists($key, $frame)) {
                        $item += $frame[$key];
                    }
                }
            }

            foreach ($average_report as &$value) {
                $value /= sizeof($reports);
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
    public static function highestEmotion($reports)
    {
        self::fixType($reports);

        $totalAverageReport = self::average($reports);

        $useful_values = self::getEmotionValues($totalAverageReport);
        if (empty($useful_values)) {
            return self::__NO_REPORT__;
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
        self::fixType($report);
        $useful_values = [
            self::JOY_KEY => 0,
            self::SADNESS_KEY => 0,
            self::DISGUST_KEY => 0,
            self::CONTEMPT_KEY => 0,
            self::ANGER_KEY => 0,
            self::FEAR_KEY => 0,
            self::SURPRISE_KEY => 0
        ];
        $type = self::getReportType($report);

        if (empty($report) || $type == 1) {
            return array_intersect_key($report, $useful_values);
        } elseif ($type == 2) {
            foreach ($report as &$frame) {
                self::fixType($frame);
                $frame = array_intersect_key($frame, $useful_values);
            }
            return $report;
        } else {
            foreach ($report as &$sub_report) {
                $sub_report = self::getEmotionValues($sub_report);
            }
            return $report;
        }
    }

    public function getReportFile(int $id)
    {
        $current_video = Video::findOrFail($id);
        return view('layout-file')
            ->with('video', $current_video)
            ->with('path', ProjectController::getProjectChain($current_video->project))
            ->with('project', $current_video->project);
    }

    public function getProjectReportFile(int $id)
    {
        $current_project = Project::findOrFail($id);
        (new ConsoleOutput())->writeln($current_project->creator === null);
        return view('layout-file-project')
            ->with('project', $current_project);
    }

    public function downloadPDF($id)
    {
//        $video = Video::findOrFail($id);
//        $pdf = \Pdf::loadView('layout-file', compact('video'));
//        $pdf->setOptions(['enable-javascript'=> true, 'javascript-delay'=>5000, 'enable-smart-shrinking'=> true, 'no-stop-slow-scripts'=>true]);
//
//        return $pdf->download('chart.pdf');
    }

    public function downloadProjectPDF($id)
    {
//        $project = Project::findOrFail($id);
//        $pdf = \Pdf::loadView('layout-file', compact('project'));
//        $pdf->setOptions(['enable-javascript'=> true, 'javascript-delay'=>5000, 'enable-smart-shrinking'=> true, 'no-stop-slow-scripts'=>true]);
//
//        return $pdf->download('chart.pdf');
    }

    public function downloadJSON($id)
    {

        $video = Video::findOrFail($id);
        $fileName = "Video-report-" . time() . ".json";
        $handle = fopen($fileName, 'w+');
        fputs($handle, $video->report);
        fclose($handle);
        $headers = array('Content-type' => 'Analysis to json', 'Video analyzed' => $video->name);

        return response()->download($fileName, $fileName, $headers)->deleteFileAfterSend();
    }

    public function downloadProjectJSON($id)
    {
        $project = Project::findOrFail($id);
        $fileName = "Project-report-" . time() . ".json";
        $handle = fopen($fileName, 'w+');
        fputs($handle, json_encode($project->report));
        fclose($handle);
        $headers = array('Content-type' => 'Analysis to json', 'Project analyzed' => $project->name);;
        return response()->download($fileName, $fileName, $headers)->deleteFileAfterSend();

    }

    public function downloadExcel($id)
    {
        $video = Video::findOrFail($id);
        $spreadsheet = new VideoSpreadsheet($video->name, $video->report);

        $spreadsheet->generateDefault();

        return response()->streamDownload(function () use ($spreadsheet) {
            $spreadsheet->getFileAsBinaryOutput();
        }, $spreadsheet->getFileName());
    }

    public function downloadProjectExcel($id)
    {
        $project = Project::findOrFail($id);
        $spreadsheet = new ProjectSpreadsheet($project->name, $project->report);

        $spreadsheet->generateDefault();

        return response()->streamDownload(function () use ($spreadsheet) {
            $spreadsheet->getFileAsBinaryOutput();
        }, $spreadsheet->getFileName());
    }

    public function downloadPPTX($id)
    {
        $video = Video::findOrFail($id);
        $presentation = new VideoPresentation($video->name, $video->report);

        $presentation->generateDefault();

        return response()->streamDownload(function () use ($presentation) {
            $presentation->getFileAsBinaryOutput();
        }, $presentation->getFileName());
    }

    public function downloadProjectPPTX($id)
    {
        $project = Project::findOrFail($id);
        $presentation = new ProjectPresentation($project->name, $project->report);

        $presentation->generateDefault();

        return response()->streamDownload(function () use ($presentation) {
            $presentation->getFileAsBinaryOutput();
        }, $presentation->getFileName());
    }
}
