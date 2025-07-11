<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Fill;

class TbrExportController extends Controller
{
    public function exportPpt($eventId)
    {
        $json = Storage::disk('public')->get('tbr/json/data.json');
        $events = json_decode($json, true);
        $event = collect($events)->firstWhere('id', $eventId);

        if (!$event) {
            return abort(404, 'Evento não encontrado');
        }

        $categories = config('tbr-config.categories');
        $modalitiesByLevel = config('tbr-config.modalities_by_level');

        $rankingConfig = $event['ranking_config'] ?? [];
        $topPositions = (int)($rankingConfig['top_positions'] ?? 0);
        $generalTopPositions = (int)($rankingConfig['general_top_positions'] ?? 3);

        $ppt = new PhpPresentation();
        $ppt->removeSlideByIndex(0);

        // Definindo Dimensao
        $slideWidth = 960;
        $slideHeight = 720;

        foreach ($categories as $category) {
            $catSlug = $category['slug'];
            $catLabel = $category['label'];
            $modalitieLevel = $category['modalitie'];
            $modalities = $modalitiesByLevel[$modalitieLevel] ?? [];

            $teamsCategory = collect($event['equipes'] ?? [])
                ->filter(fn($t) => ($t['category'] ?? '') === $catSlug)
                ->values();

            if ($teamsCategory->isEmpty()) {
                continue;
            }

            // Categoria baby: dois slides por equipe
            if ($catSlug === 'baby') {
                if ($generalTopPositions > 0) {
                    $teamsSortedTotal = $teamsCategory->sortByDesc(fn($t) => floatval($t['nota_total'] ?? 0))->values();

                    if ($teamsSortedTotal->isNotEmpty()) {
                        $teamsTopTotal = $teamsSortedTotal->take($generalTopPositions)->reverse()->values();

                        foreach ($teamsTopTotal as $pos => $team) {
                            $posNumber = $generalTopPositions - $pos;

                            // Slide 1 - categoria + posição
                            $slide1 = $ppt->createSlide();
                            $textBlock1 = $slide1->createRichTextShape()
                                ->setWidth($slideWidth)
                                ->setHeight($slideHeight)
                                ->setOffsetX(0)
                                ->setOffsetY(0);
                            $textBlock1->getFill()->setFillType(Fill::FILL_NONE);
                            $textBlock1->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                            $textBlock1->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                            $textBlock1->createTextRun("{$catLabel} - Nota Geral")
                                ->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                            $textBlock1->createBreak();

                            $textBlock1->createTextRun("{$posNumber}º Lugar")
                                ->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));

                            // Slide 2 - categoria + posição + nome equipe
                            $slide2 = $ppt->createSlide();
                            $textBlock2 = $slide2->createRichTextShape()
                                ->setWidth($slideWidth)
                                ->setHeight($slideHeight)
                                ->setOffsetX(0)
                                ->setOffsetY(0);
                            $textBlock2->getFill()->setFillType(Fill::FILL_NONE);
                            $textBlock2->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                            $textBlock2->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                            $textBlock2->createTextRun("{$catLabel} - Nota Geral")
                                ->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                            $textBlock2->createBreak();

                            $textBlock2->createTextRun("{$posNumber}º Lugar")
                                ->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));
                            $textBlock2->createBreak();

                            $textBlock2->createTextRun($team['name'])
                                ->getFont()->setBold(true)->setSize(52)->setColor(new Color('FF3399FF'));
                        }
                    }
                }
                continue; // pula o resto do loop para baby
            }


            // Para as outras categorias, gera slides para cada modalidade
            if ($topPositions > 0) {
                foreach ($modalities as $mod) {
                    $modSlug = $mod['slug'];
                    $modLabel = $mod['label'];

                    $teamsSorted = $teamsCategory->sortByDesc(fn($t) => $t['modalities'][$modSlug]['total'] ?? 0)->values();

                    if ($teamsSorted->isEmpty()) {
                        continue;
                    }

                    $teamsTop = $teamsSorted->take($topPositions)->reverse()->values();

                    foreach ($teamsTop as $pos => $team) {
                        $posNumber = $topPositions - $pos;

                        // --- Slide 1 ---
                        $slide1 = $ppt->createSlide();

                        // Texto centralizado no slide 1
                        $textBlock1 = $slide1->createRichTextShape()
                            ->setWidth($slideWidth)
                            ->setHeight($slideHeight)
                            ->setOffsetX(0)
                            ->setOffsetY(0);
                        $textBlock1->getFill()->setFillType(Fill::FILL_NONE);
                        $textBlock1->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $textBlock1->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                        $textBlock1->createTextRun("{$catLabel} - {$modLabel}")
                            ->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                        $textBlock1->createBreak();

                        $textBlock1->createTextRun("{$posNumber}º Lugar")
                            ->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));
                        $textBlock1->createBreak();

                        // --- Slide 2 ---
                        $slide2 = $ppt->createSlide();

                        // Texto centralizado no slide 2
                        $textBlock2 = $slide2->createRichTextShape()
                            ->setWidth($slideWidth)
                            ->setHeight($slideHeight)
                            ->setOffsetX(0)
                            ->setOffsetY(0);
                        $textBlock2->getFill()->setFillType(Fill::FILL_NONE);
                        $textBlock2->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $textBlock2->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                        $textBlock2->createTextRun("{$catLabel} - {$modLabel}")
                            ->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                        $textBlock2->createBreak();

                        $textBlock2->createTextRun("{$posNumber}º Lugar")
                            ->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));
                        $textBlock2->createBreak();

                        $textBlock2->createTextRun($team['name'])
                            ->getFont()->setBold(true)->setSize(52)->setColor(new Color('FF3399FF'));
                    }
                }
            }

            // Slides para nota geral da categoria (exceto baby, que já foi tratado)
            if ($generalTopPositions > 0) {
                $teamsSortedTotal = $teamsCategory->sortByDesc(fn($t) => floatval($t['nota_total'] ?? 0))->values();

                if ($teamsSortedTotal->isNotEmpty()) {
                    $teamsTopTotal = $teamsSortedTotal->take($generalTopPositions)->reverse()->values();

                    foreach ($teamsTopTotal as $pos => $team) {
                        $posNumber = $generalTopPositions - $pos;

                        // --- Slide 1 ---
                        $slide1 = $ppt->createSlide();

                        // Texto centralizado
                        $textBlock1 = $slide1->createRichTextShape()
                            ->setWidth($slideWidth)
                            ->setHeight($slideHeight)
                            ->setOffsetX(0)
                            ->setOffsetY(0);
                        $textBlock1->getFill()->setFillType(Fill::FILL_NONE);
                        $textBlock1->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $textBlock1->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                        $textBlock1->createTextRun("{$catLabel} - Nota Geral")
                            ->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                        $textBlock1->createBreak();

                        $textBlock1->createTextRun("{$posNumber}º Lugar")
                            ->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));

                        // --- Slide 2 ---
                        $slide2 = $ppt->createSlide();

                        // Texto centralizado
                        $textBlock2 = $slide2->createRichTextShape()
                            ->setWidth($slideWidth)
                            ->setHeight($slideHeight)
                            ->setOffsetX(0)
                            ->setOffsetY(0);
                        $textBlock2->getFill()->setFillType(Fill::FILL_NONE);
                        $textBlock2->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $textBlock2->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                        $textBlock2->createTextRun("{$catLabel} - Nota Geral")
                            ->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                        $textBlock2->createBreak();

                        $textBlock2->createTextRun("{$posNumber}º Lugar")
                            ->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));
                        $textBlock2->createBreak();

                        $textBlock2->createTextRun($team['name'])
                            ->getFont()->setBold(true)->setSize(52)->setColor(new Color('FF3399FF'));
                    }
                }
            }
        }

        $eventName = $event['nome'] ?? 'evento';
        $eventDateRaw = $event['data'] ?? null;
        $eventDate = 'sem_data';

        if ($eventDateRaw) {
            try {
                $dateObj = new \DateTime($eventDateRaw);
                $eventDate = $dateObj->format('Y_m_d');
            } catch (\Exception $e) {
            }
        }

        $safeEventName = iconv('UTF-8', 'ASCII//TRANSLIT', $eventName);
        $safeEventName = preg_replace('/[^A-Za-z0-9]+/', '_', $safeEventName);
        $safeEventName = strtolower(trim($safeEventName, '_'));

        $fileName = "{$safeEventName}_{$eventDate}.pptx";
        $tempFile = storage_path('app/public/' . $fileName);
        IOFactory::createWriter($ppt, 'PowerPoint2007')->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
