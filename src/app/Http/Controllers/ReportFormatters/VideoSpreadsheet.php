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


class VideoSpreadsheet extends ReportSpreadsheet
{
    /**
     * @inheritDoc
     */
    public function generateDefault()
    {
        $sheet = $this->spreadsheet->getActiveSheet();
        if (!empty($this->report)) {
            $sheet->setCellValue('A1', 'Frame');
            foreach ($this->report as $index => $frame) {
                $sheet->setCellValue($this->getColumnFromNumber($index + 2) . '1', $index + 1);
                $value_index = 2;
                foreach ($frame as $key => $value) {
                    if ($index == 0) {
                        $sheet->setCellValue('A' . $value_index, $key);
                    }
                    $sheet->setCellValue($this->getColumnFromNumber($index + 2) . $value_index, $value);
                    $value_index++;
                }
            }
        }
    }
}
