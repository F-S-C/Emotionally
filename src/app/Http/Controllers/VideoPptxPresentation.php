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


class VideoPptxPresentation extends ReportPptxPresentation
{
    protected const TYPE = 'VIDEO';

    public function __construct(string $title, $report)
    {
        parent::__construct($title, $report);
        $this->presentation->setTitle('Video report - ' . $title)
            ->setSubject('Video report');
    }

}
