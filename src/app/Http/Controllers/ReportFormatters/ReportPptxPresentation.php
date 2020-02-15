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

use Emotionally\Http\Controllers\ReportController;
use PhpOffice\PhpPresentation\DocumentLayout;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Shape\Drawing\Base64;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Slide;
use PhpOffice\PhpPresentation\Slide\Background\Color as BackgroundColor;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Color;

abstract class ReportPptxPresentation
{

    protected const COLOR_PRIMARY = 'FFFF9800';
    protected const COLOR_WHITE = 'FFFFFFFF';

    /**
     * The type of report
     */
    protected const TYPE = 'NO TYPE';

    /**
     * @var PhpPresentation The presentation
     */
    protected $presentation;
    protected $title;

    /**
     * @var array The report of the presentation
     */
    protected $report;

    /**
     * @var Slide The title slide.
     */
    protected $title_slide;

    /**
     * @var array<Slide> The presentation slides.
     */
    protected $slides;

    /**
     * ReportPptxPresentation constructor.
     * @param string $title The title of the presentation.
     * @param array|string $report The report to be presented.
     */
    public function __construct(string $title, $report)
    {
        $this->slides = array();
        $this->title = trim($title);

        if (is_string($report)) {
            $report = json_decode($report, true);
        } elseif (!is_array($report)) {
            throw new \InvalidArgumentException('$report must be a string or an array');
        }
        $this->report = $report;

        $this->presentation = new PhpPresentation();

        $this->presentation->getDocumentProperties()
            ->setTitle($title)
            ->setCreator(\Auth::user()->name . ' ' . \Auth::user()->surname)
            ->setLastModifiedBy('Emotionally - FSC');

        $this->presentation->getLayout()
            ->setDocumentLayout(DocumentLayout::LAYOUT_SCREEN_16X9);
    }

    /**
     * Create the title slide.
     */
    public function createTitleSlide()
    {
        $this->title_slide = $this->presentation->getActiveSlide();
        $background = (new BackgroundColor())->setColor(new Color(self::COLOR_PRIMARY));
        $this->title_slide->setBackground($background);

        $shape = $this->title_slide->createRichTextShape()
            ->setHeight(300)
            ->setWidth(600)
            ->setOffsetX(180)
            ->setOffsetY(120);

        $shape->getActiveParagraph()->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $textRun = $shape->createTextRun($this::TYPE);
        $textRun->getFont()
            ->setSize(32)
            ->setCharacterSpacing(16)
            ->setColor(new Color(self::COLOR_WHITE));

        $shape->createBreak();

        $textRun = $shape->createTextRun('“' . $this->title . '”');
        $textRun->getFont()
            ->setBold(true)
            ->setSize(60)
            ->setColor(new Color(self::COLOR_WHITE));

        $shape->createBreak();

        $textRun = $shape->createTextRun('Generated by Emotionally, made with love by FSC');
        $textRun->getFont()
            ->setSize(11)
            ->setColor(new Color('DDFFFFFF'));

        array_push($this->slides, $this->title_slide);
        return $this;
    }

    /**
     * @return Slide Get a reference to the title slide.
     */
    public function getTitleSlide()
    {
        return $this->title_slide;
    }

    /**
     * Get the output file name.
     * @return string The file name. It consist of an ISO timestamp, the presentation title and an extension.
     */
    public function getFileName()
    {
        try {
            $date = new \DateTime();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return '00000000T000000 - ' . $this->title . '.pptx';
        }
        $base_iso_date_format = 'Ymd\THis';
        return $date->format($base_iso_date_format) . ' - ' . $this->title . '.pptx';
    }

    /**
     * Download the presentation as a Power Point 2007 file (.pptx).
     * @throws \Exception
     */
    public function downloadPresentation()
    {
        $writer = IOFactory::createWriter($this->presentation, 'PowerPoint2007');
        $writer->save('php://output');
    }

    /**
     * Add a slide containing the highest emotion.
     * @return $this
     */
    public function addHighestEmotionSlide()
    {
        $averageEmotion = ReportController::highestEmotion($this->report);
        $new_slide = $this->presentation->createSlide();
        array_push($this->slides, $new_slide);

        $title_shape = $new_slide->createRichTextShape()
            ->setWidth(300)
            ->setHeight(60)
            ->setOffsetX(70)
            ->setOffsetY(50)
            ->setAutofit(RichText::AUTOFIT_SHAPE);

        $title = $title_shape->createTextRun('Modal Emotion');
        $title->getFont()
            ->setSize(32)
            ->setColor(new Color(self::COLOR_PRIMARY));

        // Image (emoji)
        $image_offset_x = 355;
        $image_width = 248;
        $shape = $new_slide->createDrawingShape();
        $shape->setName('Modal emotion')
            ->setDescription('Modal emotion: ' . $averageEmotion)
            ->setPath('images/emotions/' . $averageEmotion . '.png')
            ->setResizeProportional(false)
            ->setHeight($image_width)
            ->setWidth($image_width)
            ->setOffsetX($image_offset_x)
            ->setOffsetY(150);
        $shape->getShadow()->setVisible(true)
            ->setDirection(45)
            ->setDistance(10);

        // Image caption
        $desc_shape = $new_slide->createRichTextShape()
            ->setWidth($image_width)
            ->setHeight(30)
            ->setOffsetX($image_offset_x)
            ->setOffsetY(420)
            ->setAutofit(RichText::AUTOFIT_SHAPE);

        $desc_shape->getActiveParagraph()->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $desc = $desc_shape->createTextRun(strtoupper($averageEmotion));
        $desc->getFont()
            ->setSize(16)
            ->setCharacterSpacing(6)
            ->setColor(new Color('FF777777'));

        return $this;
    }

    /**
     * Generate the default presentation.
     * @return $this
     */
    public abstract function generateDefaultPresentation();
}
