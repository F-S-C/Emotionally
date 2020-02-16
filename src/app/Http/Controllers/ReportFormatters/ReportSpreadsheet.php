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

namespace Emotionally\Http\Controllers\ReportFormatters;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReportSpreadsheet extends ReportFormatter
{
    /**
     * @var Spreadsheet The spreadsheet.
     */
    protected $spreadsheet;

    public function __construct(string $title, $report)
    {
        parent::__construct($title, $report);
        $this->spreadsheet = new Spreadsheet();
    }

    /**
     * @inheritDoc
     */
    public function getFileAsBinaryOutput()
    {
        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    /**
     * @inheritDoc
     */
    public function getFileName()
    {
        return $this->getFileBaseName() . '.xlsx';
    }

    /**
     * @inheritDoc
     */
    public function generateDefault()
    {
        // TODO: Implement generateDefault() method.
        foreach ($this->report as $key => $value) {
            $sheet = $this->spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', $key);
        }
    }
}
