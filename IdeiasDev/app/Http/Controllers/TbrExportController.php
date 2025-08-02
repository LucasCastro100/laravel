<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\PhpPresentation\Shape\Drawing\File as DrawingFile;
use Illuminate\Support\Facades\Log;

use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Dompdf\Dompdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class TbrExportController extends Controller
{
    // Função para logar o uso de memória e pico de memória
    function logMemoryUsage(string $label = '')
    {
        $usageBytes = memory_get_usage();
        $usageMB = round($usageBytes / 1024 / 1024, 2);

        $peakBytes = memory_get_peak_usage();
        $peakMB = round($peakBytes / 1024 / 1024, 2);

        $msg = $label ? "[$label] " : '';
        $msg .= "Memória usada: {$usageBytes} bytes ({$usageMB} MB); ";
        $msg .= "Pico de memória: {$peakBytes} bytes ({$peakMB} MB)";

        Log::info($msg);
    }

    private function createBackground($slide, $imagePath, $width, $height)
    {
        $bg = new DrawingFile();
        $bg->setName('Background')
            ->setDescription('Imagem de fundo')
            ->setPath($imagePath)
            ->setWidth($width)
            ->setHeight($height)
            ->setOffsetX(0)
            ->setOffsetY(0);
        $slide->addShape($bg);
    }

    private function addAwardSlides($ppt, $slideWidth, $slideHeight, $imagePath, string $title, int $position, ?string $teamName = null)
    {
        // Primeiro slide (sem nome)
        $slide1 = $ppt->createSlide();
        $this->createBackground($slide1, $imagePath, $slideWidth, $slideHeight);
        $text1 = $slide1->createRichTextShape()
            ->setWidth($slideWidth)
            ->setHeight($slideHeight)
            ->setOffsetX(0)
            ->setOffsetY(0);
        $text1->getFill()->setFillType(Fill::FILL_NONE);
        $text1->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $text1->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $text1->createTextRun($title)->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
        $text1->createBreak();
        $text1->createTextRun("{$position}º Lugar")->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));
        gc_collect_cycles();

        // Segundo slide (com nome, se houver)
        $slide2 = $ppt->createSlide();
        $this->createBackground($slide2, $imagePath, $slideWidth, $slideHeight);
        $text2 = $slide2->createRichTextShape()
            ->setWidth($slideWidth)
            ->setHeight($slideHeight)
            ->setOffsetX(0)
            ->setOffsetY(0);
        $text2->getFill()->setFillType(Fill::FILL_NONE);
        $text2->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $text2->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $text2->createTextRun($title)->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
        $text2->createBreak();
        $text2->createTextRun("{$position}º Lugar")->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));

        if ($teamName) {
            $text2->createBreak();
            $text2->createTextRun($teamName)->getFont()->setBold(true)->setSize(52)->setColor(new Color('FF3399FF'));
        }

        gc_collect_cycles();
    }

    public function pptx($eventId)
    {
        ini_set('memory_limit', '1024M'); // 1GB
        set_time_limit(900);

        $this->logMemoryUsage('Início do método');

        $json = Storage::disk('public')->get('tbr/json/data.json');
        $this->logMemoryUsage('Após carregar JSON');

        $events = json_decode($json, true);
        $event = collect($events)->firstWhere('id', $eventId);
        $this->logMemoryUsage('Após decodificar JSON e pegar evento');

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

        $slideWidth = 960;
        $slideHeight = 720;

        // Slide inicial com nome do evento
        $slideTitle = $ppt->createSlide();
        $shape = $slideTitle->createRichTextShape()
            ->setWidth($slideWidth)
            ->setHeight($slideHeight)
            ->setOffsetX(0)
            ->setOffsetY(0);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $shape->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $shape->createTextRun($event['nome'] ?? 'Evento')
            ->getFont()->setBold(true)->setSize(72)->setColor(new Color('FF000000'));

        // Loop de categorias
        foreach ($categories as $category) {
            $catSlug = $category['slug'];
            $catLabel = $category['label'];
            $modalitieLevel = $category['modalitie'];
            $modalities = $modalitiesByLevel[$modalitieLevel] ?? [];

            $teamsCategory = collect($event['equipes'] ?? [])->filter(fn($t) => ($t['category'] ?? '') === $catSlug)->values();
            if ($teamsCategory->isEmpty()) continue;

            $this->logMemoryUsage("Após filtrar equipes da categoria $catSlug");

            // Categoria baby - apenas nota geral
            if ($catSlug === 'baby' && $generalTopPositions > 0) {
                $teamsSortedTotal = $teamsCategory->sortByDesc(fn($t) => floatval($t['nota_total'] ?? 0))->values();
                $teamsTopTotal = $teamsSortedTotal->take($generalTopPositions)->reverse()->values();

                foreach ($teamsTopTotal as $pos => $team) {
                    $posNumber = $generalTopPositions - $pos;

                    // Slide 1
                    $slide1 = $ppt->createSlide();
                    $shape1 = $slide1->createRichTextShape()
                        ->setWidth($slideWidth)
                        ->setHeight($slideHeight)
                        ->setOffsetX(0)
                        ->setOffsetY(0);
                    $shape1->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $shape1->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $shape1->createTextRun("{$catLabel} - Nota Geral")->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                    $shape1->createBreak();
                    $shape1->createTextRun("{$posNumber}º Lugar")->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));

                    // Slide 2
                    $slide2 = $ppt->createSlide();
                    $shape2 = $slide2->createRichTextShape()
                        ->setWidth($slideWidth)
                        ->setHeight($slideHeight)
                        ->setOffsetX(0)
                        ->setOffsetY(0);
                    $shape2->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $shape2->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $shape2->createTextRun("{$catLabel} - Nota Geral")->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                    $shape2->createBreak();
                    $shape2->createTextRun("{$posNumber}º Lugar")->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));
                    $shape2->createBreak();
                    $shape2->createTextRun($team['name'])->getFont()->setBold(true)->setSize(52)->setColor(new Color('FF3399FF'));
                }

                continue;
            }

            // Por modalidade
            if ($topPositions > 0) {
                foreach ($modalities as $mod) {
                    $modSlug = $mod['slug'];
                    $modLabel = $mod['label'];
                    $teamsSorted = $teamsCategory->sortByDesc(fn($t) => $t['modalities'][$modSlug]['total'] ?? 0)->values();
                    if ($teamsSorted->isEmpty()) continue;

                    $teamsTop = $teamsSorted->take($topPositions)->reverse()->values();

                    foreach ($teamsTop as $pos => $team) {
                        $posNumber = $topPositions - $pos;

                        // Slide 1
                        $slide1 = $ppt->createSlide();
                        $shape1 = $slide1->createRichTextShape()
                            ->setWidth($slideWidth)
                            ->setHeight($slideHeight)
                            ->setOffsetX(0)
                            ->setOffsetY(0);
                        $shape1->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $shape1->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $shape1->createTextRun("{$catLabel} - {$modLabel}")->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                        $shape1->createBreak();
                        $shape1->createTextRun("{$posNumber}º Lugar")->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));

                        // Slide 2
                        $slide2 = $ppt->createSlide();
                        $shape2 = $slide2->createRichTextShape()
                            ->setWidth($slideWidth)
                            ->setHeight($slideHeight)
                            ->setOffsetX(0)
                            ->setOffsetY(0);
                        $shape2->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $shape2->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $shape2->createTextRun("{$catLabel} - {$modLabel}")->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                        $shape2->createBreak();
                        $shape2->createTextRun("{$posNumber}º Lugar")->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));
                        $shape2->createBreak();
                        $shape2->createTextRun($team['name'])->getFont()->setBold(true)->setSize(52)->setColor(new Color('FF3399FF'));
                    }
                }
            }

            // Nota geral (se não for baby)
            if ($generalTopPositions > 0 && $catSlug !== 'baby') {
                $teamsSortedTotal = $teamsCategory->sortByDesc(fn($t) => floatval($t['nota_total'] ?? 0))->values();
                $teamsTopTotal = $teamsSortedTotal->take($generalTopPositions)->reverse()->values();

                foreach ($teamsTopTotal as $pos => $team) {
                    $posNumber = $generalTopPositions - $pos;

                    // Slide 1
                    $slide1 = $ppt->createSlide();
                    $shape1 = $slide1->createRichTextShape()
                        ->setWidth($slideWidth)
                        ->setHeight($slideHeight)
                        ->setOffsetX(0)
                        ->setOffsetY(0);
                    $shape1->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $shape1->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $shape1->createTextRun("{$catLabel} - Nota Geral")->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                    $shape1->createBreak();
                    $shape1->createTextRun("{$posNumber}º Lugar")->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));

                    // Slide 2
                    $slide2 = $ppt->createSlide();
                    $shape2 = $slide2->createRichTextShape()
                        ->setWidth($slideWidth)
                        ->setHeight($slideHeight)
                        ->setOffsetX(0)
                        ->setOffsetY(0);
                    $shape2->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $shape2->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $shape2->createTextRun("{$catLabel} - Nota Geral")->getFont()->setBold(true)->setSize(48)->setColor(new Color('FF000000'));
                    $shape2->createBreak();
                    $shape2->createTextRun("{$posNumber}º Lugar")->getFont()->setBold(true)->setSize(56)->setColor(new Color('FFFFCC00'));
                    $shape2->createBreak();
                    $shape2->createTextRun($team['name'])->getFont()->setBold(true)->setSize(52)->setColor(new Color('FF3399FF'));
                }
            }
        }

        // Slide final
        $slideThankYou = $ppt->createSlide();
        $shapeThankYou = $slideThankYou->createRichTextShape()
            ->setWidth($slideWidth)
            ->setHeight($slideHeight)
            ->setOffsetX(0)
            ->setOffsetY(0);
        $shapeThankYou->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $shapeThankYou->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $shapeThankYou->createTextRun("Muito obrigado pela participação!")
            ->getFont()->setBold(true)->setSize(60)->setColor(new Color('FF000000'));

        $this->logMemoryUsage('Após criar todos os slides');

        // Nome do arquivo
        $eventName = $event['nome'] ?? 'evento';
        $eventDateRaw = $event['data'] ?? null;
        $eventDate = 'sem_data';

        if ($eventDateRaw) {
            try {
                $dateObj = new \DateTime($eventDateRaw);
                $eventDate = $dateObj->format('Y_m_d');
            } catch (\Exception $e) {
                // ignora
            }
        }

        $safeEventName = iconv('UTF-8', 'ASCII//TRANSLIT', $eventName);
        $safeEventName = preg_replace('/[^A-Za-z0-9]+/', '_', $safeEventName);
        $safeEventName = strtolower(trim($safeEventName, '_'));

        $fileName = "{$safeEventName}_{$eventDate}.pptx";
        $tempFile = storage_path('app/public/' . $fileName);

        $this->logMemoryUsage('Antes de salvar o arquivo PPTX');
        IOFactory::createWriter($ppt, 'PowerPoint2007')->save($tempFile);
        $this->logMemoryUsage('Após salvar o arquivo PPTX');

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function pdf($eventId)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(900);

        $this->logMemoryUsage('Início do método PDF');

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

        $backgroundPath = storage_path('app/public/tbr/image/apresentacao/img.jpg');
        if (!file_exists($backgroundPath)) {
            abort(500, 'Imagem de fundo não encontrada.');
        }
        $backgroundData = base64_encode(file_get_contents($backgroundPath));
        $backgroundBase64 = 'data:image/jpg;base64,' . $backgroundData;

        $html = <<<HTML
    <style>
        @page { size: A4 landscape; margin: 0; }
        html, body {
            margin: 0;
            padding: 0;
            height: 210mm;
            width: 100%;
            font-family: Arial, sans-serif;
            background-image: url("$backgroundBase64");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
        }
        .page {
            width: 100%;
            height: 100%;
            page-break-after: always;
            background-color: rgba(0, 0, 0, 0.5);
            box-sizing: border-box;
        }
        .content-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            text-align: center;        
        }
        h1, h2, h3 {
            margin: 0;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.7);
        }
        .title-event {
            font-size: 5rem;
            font-weight: bold;
        }
        .title-category {
            font-size: 5rem;
            font-weight: bold;
        }
        .title-sub {
            font-size: 4rem;
            font-weight: bold;
        }
        .position {
            font-size: 4rem;
            font-weight: bold;
            color: #FFCC00;
        }
        .team-name {
            font-size: 3rem;
            font-weight: bold;
            color: #00AAFF;
        }
        .thank-you {
            font-size: 72px;
            font-weight: bold;
        }
    </style>
    HTML;

        $html .= '<div class="page"><div class="content-center">';
        $html .= '<h1 class="title-event">' . htmlspecialchars($event['nome'] ?? 'Evento') . '</h1>';
        $html .= '</div></div>';

        foreach ($categories as $category) {
            $catSlug = $category['slug'];
            $catLabel = $category['label'];
            $modalitieLevel = $category['modalitie'];
            $modalities = $modalitiesByLevel[$modalitieLevel] ?? [];

            $teamsCategory = collect($event['equipes'] ?? [])
                ->filter(fn($t) => ($t['category'] ?? '') === $catSlug)
                ->values();

            if ($teamsCategory->isEmpty()) continue;

            // Baby com Nota Geral
            if ($catSlug === 'baby' && $generalTopPositions > 0) {
                $teamsSortedTotal = $teamsCategory->sortByDesc(fn($t) => floatval($t['nota_total'] ?? 0))->values();
                $teamsTopTotal = $teamsSortedTotal->take($generalTopPositions)->reverse()->values();

                foreach ($teamsTopTotal as $pos => $team) {
                    $posNumber = $generalTopPositions - $pos;

                    $html .= '<div class="page"><div class="content-center">';
                    $html .= "<h2 class='title-category'>{$catLabel}</h2>";
                    $html .= "<h3 class='title-sub'>Nota Geral</h3>";
                    $html .= "<h3 class='position'>{$posNumber}º Lugar</h3>";
                    $html .= '</div></div>';

                    $html .= '<div class="page"><div class="content-center">';
                    $html .= "<h2 class='title-category'>{$catLabel}</h2>";
                    $html .= "<h3 class='title-sub'>Nota Geral</h3>";
                    $html .= "<h3 class='position'>{$posNumber}º Lugar</h3>";
                    $html .= "<h2 class='team-name'>" . htmlspecialchars($team['name']) . "</h2>";
                    $html .= '</div></div>';
                }
                continue;
            }

            if ($topPositions > 0) {
                foreach ($modalities as $mod) {
                    $modSlug = $mod['slug'];
                    $modLabel = $mod['label'];

                    $teamsSorted = $teamsCategory->sortByDesc(fn($t) => $t['modalities'][$modSlug]['total'] ?? 0)->values();
                    if ($teamsSorted->isEmpty()) continue;

                    $teamsTop = $teamsSorted->take($topPositions)->reverse()->values();

                    foreach ($teamsTop as $pos => $team) {
                        $posNumber = $topPositions - $pos;

                        $html .= '<div class="page"><div class="content-center">';
                        $html .= "<h2 class='title-category'>{$catLabel}</h2>";  // Categoria em linha separada
                        $html .= "<h2 class='title-category'>{$modLabel}</h2>"; // Modalidade abaixo, separado
                        $html .= "<h3 class='position'>{$posNumber}º Lugar</h3>";
                        $html .= '</div></div>';

                        $html .= '<div class="page"><div class="content-center">';
                        $html .= "<h2 class='title-category'>{$catLabel}</h2>";
                        $html .= "<h2 class='title-category'>{$modLabel}</h2>";
                        $html .= "<h3 class='position'>{$posNumber}º Lugar</h3>";
                        $html .= "<h2 class='team-name'>" . htmlspecialchars($team['name']) . "</h2>";
                        $html .= '</div></div>';
                    }
                }
            }

            if ($generalTopPositions > 0) { // Nota geral para todas as categorias, inclusive baby já tratado acima, mas aqui não entra baby pois já continuou.
                if ($catSlug !== 'baby') {
                    $teamsSortedTotal = $teamsCategory->sortByDesc(fn($t) => floatval($t['nota_total'] ?? 0))->values();
                    $teamsTopTotal = $teamsSortedTotal->take($generalTopPositions)->reverse()->values();

                    foreach ($teamsTopTotal as $pos => $team) {
                        $posNumber = $generalTopPositions - $pos;

                        $html .= '<div class="page"><div class="content-center">';
                        $html .= "<h2 class='title-category'>{$catLabel}</h2>";
                        $html .= "<h3 class='title-sub'>Nota Geral</h3>";
                        $html .= "<h3 class='position'>{$posNumber}º Lugar</h3>";
                        $html .= '</div></div>';

                        $html .= '<div class="page"><div class="content-center">';
                        $html .= "<h2 class='title-category'>{$catLabel}</h2>";
                        $html .= "<h3 class='title-sub'>Nota Geral</h3>";
                        $html .= "<h3 class='position'>{$posNumber}º Lugar</h3>";
                        $html .= "<h2 class='team-name'>" . htmlspecialchars($team['name']) . "</h2>";
                        $html .= '</div></div>';
                    }
                }
            }
        }

        $html .= '<div class="page"><div class="content-center">';
        $html .= '<h1 class="thank-you">Muito obrigado pela participação!</h1>';
        $html .= '</div></div>';


        $dompdf = new Dompdf(['enable_remote' => true]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $this->logMemoryUsage('Após gerar PDF');

        $eventName = Str::slug($event['nome'] ?? 'evento', '_');
        $eventDate = $event['data'] ?? now()->format('Y-m-d');
        $eventDateSlug = Str::slug($eventDate, '_');

        $fileName = strtolower("{$eventName}_{$eventDateSlug}.pdf");

        return response($dompdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function scoresPdf($eventId)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(900);

        $json = Storage::disk('public')->get('tbr/json/data.json');
        $events = json_decode($json, true);

        $event = collect($events)->firstWhere('id', $eventId);
        if (!$event) {
            return abort(404, 'Evento não encontrado');
        }

        $categories = config('tbr-config.categories');
        $modalitiesByLevel = config('tbr-config.modalities_by_level');
        $questionsByLevel = config('tbr-config.questions_by_level');
        $dpByLevel = config('tbr-config.dp_by_level');

        $eventNameSlug = Str::slug($event['nome'] ?? 'evento');
        $tempDir = storage_path("app/public/tmp/{$eventNameSlug}");

        if (File::exists($tempDir)) File::deleteDirectory($tempDir);
        File::makeDirectory($tempDir, 0755, true);

        $teamsByCategory = [];
        foreach ($categories as $category) {
            $catSlug = $category['slug'];
            $teams = collect($event['equipes'])->filter(fn($t) => $t['category'] === $catSlug)
                ->sortByDesc(fn($t) => floatval($t['nota_total'] ?? 0))->values();
            $teamsByCategory[$catSlug] = $teams;
        }

        $backgroundPath = storage_path('app/public/tbr/image/apresentacao/img.jpg');
        if (!file_exists($backgroundPath)) abort(500, 'Imagem de fundo não encontrada.');
        $backgroundBase64 = 'data:image/jpg;base64,' . base64_encode(file_get_contents($backgroundPath));

        foreach ($event['equipes'] as $team) {
            $teamId = $team['id'] ?? null;
            if (!$teamId) continue;

            $categorySlug = $team['category'];
            $category = collect($categories)->firstWhere('slug', $categorySlug);
            if (!$category) continue;

            $categoryLabel = $category['label'];
            $modalitieLevel = $category['modalitie'];
            $modalities = $modalitiesByLevel[$modalitieLevel] ?? [];
            $questionsConfigLevel = $questionsByLevel[$modalitieLevel] ?? [];
            $dpConfigLevel = $dpByLevel[$category['dp']] ?? [];

            $position = collect($teamsByCategory[$categorySlug])->search(fn($t) => $t['id'] === $teamId) + 1;

            $html = <<<HTML
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
            <meta charset="UTF-8">
            <style>
            @page { size: A4 portrait; margin: 0; }
            html, body {
            margin: 0;
            padding: 0;
            height: 297mm;
            width: 100%;
            font-family: Arial, sans-serif;
            background-image: url("$backgroundBase64");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
        }
        .page {
            width: 100%;
            height: 100%;
            page-break-after: always;
            background-color: rgba(0, 0, 0, 0.5);
            box-sizing: border-box;
        }
        .content-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            text-align: center;        
        }
        .content-normal {
            width: 100%;
            text-align: center;   
        }
            h1.title-event { font-size: 26pt; margin-bottom: 10pt; }
            h2.team-name { font-size: 22pt; color: #00AAFF; margin-bottom: 6pt; }
            p.position, p.total, p.category {
                font-size: 14pt;
                font-weight: bold;
                color: #FFCC00;
                margin: 0;
            }
            h2.modality-title {
                font-size: 18pt;
                padding: 10px;
                text-align: center;
                color: #fff;
            }
            .tables-wrapper {                
                display: flex;
                justify-content: space-between;
                width: 100%;                
                position: relative;                
            }
            .table-container_direita{
                width: 60%;
            }
            .table-container_esquerda {
                width: 30%;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 10pt;
                color: white;                
            }
            .bloco_filho_direita {
            position: absolute;
            right: 10px;
            top: 0px;
        }

        .bloco_filho_esquerda {
            position: absolute;
            left: 10px;
            top: 0px;
        }
        .bloco_filho_direita table{
            margin-bottom: 10px;
        }
            th, td {
                border: 1px solid white;
                padding: 4px;
                text-align: center;
            }
            th {
                background-color: rgba(255, 255, 255, 0.1);
            }
            td.desc {
                text-align: left;
            }
            .comment {
                font-size: 7pt;
                font-style: italic;
                color: #fff;                
            }
        </style>
        </head>
        <body>
        HTML;

            // Página de capa
            $html .= '<div class="page">';
            $html .= '<div class="content-center">';
            $html .= '<h1 class="title-event">' . htmlspecialchars($event['nome']) . '</h1>';
            $html .= '<h2 class="team-name">' . htmlspecialchars($team['name']) . '</h2>';
            $html .= '<p class="position">Posição Geral: ' . $position . '</p>';
            $html .= '<p class="total">Nota Total: ' . number_format($team['nota_total'], 2) . '</p>';
            $html .= '<p class="category">Categoria: ' . htmlspecialchars($categoryLabel) . '</p>';
            $html .= '</div></div>';

            // Modalidades
            foreach ($modalities as $mod) {
                $modSlug = $mod['slug'];
                $modLabel = $mod['label'];

                $questionsConfigList = [];
                foreach ($questionsConfigLevel as $qConf) {
                    if ($qConf['modality'] === $modSlug) {
                        $questionsConfigList = $qConf['assessment'] ?? [];
                        break;
                    }
                }

                $teamNotes = $team['modalities'][$modSlug]['nota'] ?? [];
                $teamComment = $team['modalities'][$modSlug]['comentario'] ?? '';

                $notasModalidade = [];
                foreach ($teamsByCategory[$categorySlug] as $catTeam) {
                    $nota = $catTeam['modalities'][$modSlug]['total'] ?? null;
                    if ($nota !== null) $notasModalidade[] = floatval($nota);
                }

                $media = count($notasModalidade) ? array_sum($notasModalidade) / count($notasModalidade) : 0;
                $maxima = count($notasModalidade) ? max($notasModalidade) : 0;
                $notaEquipe = floatval($team['modalities'][$modSlug]['total'] ?? 0);

                $html .= '<div class="page">';
                $html .= '<div class="content-normal">';
                $html .= '<h2 class="modality-title">' . htmlspecialchars($modLabel) . '</h2>';
                $html .= '<div class="tables-wrapper">';

                // Tabela 1 - Descrição + notas
                $html .= '<div class="table-container_direita bloco_filho_esquerda"><table><thead><tr><th>Descrição</th><th>Nota</th></tr></thead><tbody>';
                if ($modSlug == 'dp') {
                    // Pega as notas dos rounds do time para dp
                    $dpNotasRounds = $team['modalities']['dp']['nota'] ?? [];

                    // Soma os valores de cada round (r1, r2, r3)
                    $somasRounds = [];
                    foreach (['r1', 'r2', 'r3'] as $roundKey) {
                        $valores = $dpNotasRounds[$roundKey] ?? [];
                        $somasRounds[$roundKey] = array_sum(array_map('floatval', $valores));
                    }

                    // Identifica qual round tem maior soma
                    $roundMaior = array_keys($somasRounds, max($somasRounds))[0] ?? null;

                    // Pega as notas do round maior
                    $notasRoundMaior = $roundMaior ? ($dpNotasRounds[$roundMaior] ?? []) : [];

                    // Agora monta a tabela usando as descrições do dpConfigLevel['itens']
                    foreach ($dpConfigLevel as $index => $item) {                        
                        $nota = isset($notasRoundMaior[$index]) ? number_format(floatval($notasRoundMaior[$index]), 2) : '-';
                        // dd($item, $nota);
                        $html .= '<tr><td class="desc">' . htmlspecialchars($item['description']) . '</td><td>' . $nota . '</td></tr>';
                    }
                } else {
                    // Caso diferente de dp, processa normal
                    foreach ($questionsConfigList as $block) {
                        foreach ($block['description'] ?? [] as $i => $desc) {
                            $nota = isset($teamNotes[$i]) ? number_format(floatval($teamNotes[$i]), 2) : '-';
                            $html .= '<tr><td class="desc">' . htmlspecialchars($desc) . '</td><td>' . $nota . '</td></tr>';
                        }
                    }
                }

                $html .= '</tbody></table></div>';

                // Tabela 2 - Equipe / Média / Máxima + comentário
                $html .= '<div class="table-container_esquerda bloco_filho_direita">';

                // Tabela: Nota da equipe
                $html .= '<table><thead><tr><th>Nota da Equipe</th></tr></thead><tbody>';
                $html .= '<tr><td>' . number_format($notaEquipe, 2) . '</td></tr>';
                $html .= '</tbody></table>';

                // Tabela: Média da categoria
                $html .= '<table><thead><tr><th>Média da Categoria</th></tr></thead><tbody>';
                $html .= '<tr><td>' . number_format($media, 2) . '</td></tr>';
                $html .= '</tbody></table>';

                // Tabela: Nota Máxima
                $html .= '<table><thead><tr><th>Nota Máxima</th></tr></thead><tbody>';
                $html .= '<tr><td>' . number_format($maxima, 2) . '</td></tr>';
                $html .= '</tbody></table>';

                // Comentário (se existir)
                if ($teamComment) {
                    $html .= '<table><thead><tr><th>Comentário</th></tr></thead><tbody>';
                    $html .= '<tr><td>' . nl2br(htmlspecialchars($teamComment)) . '</td></tr>';
                    $html .= '</tbody></table>';
                } else {
                    $html .= '<table><thead><tr><th>Comentário</th></tr></thead><tbody>';
                    $html .= '<tr><td></td></tr>';
                    $html .= '</tbody></table>';
                }

                $html .= '</div></div>'; // fecha container 2
                $html .= '</div></div>'; // fecha wrapper + page
            }

            $html .= '</body></html>';

            $dompdf = new \Dompdf\Dompdf(['enable_remote' => true]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // 🔹 Cria subpasta da categoria dentro do evento
            $categorySlug = $team['category'] ?? 'sem_categoria';
            $categoryDir = "{$tempDir}/{$categorySlug}";
            if (!File::exists($categoryDir)) {
                File::makeDirectory($categoryDir, 0755, true);
            }

            $fileName = Str::slug($team['name'], '_') . '.pdf';
            file_put_contents("{$categoryDir}/{$fileName}", $dompdf->output());
        }

        // ZIP final
        $zipPath = storage_path("app/public/tmp/{$eventNameSlug}.zip");
        if (File::exists($zipPath)) File::delete($zipPath);

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE) === true) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($tempDir),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($tempDir) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
        }

        File::deleteDirectory($tempDir);
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
