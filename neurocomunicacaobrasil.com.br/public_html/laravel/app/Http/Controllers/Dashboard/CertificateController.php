<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function generate($courseUuid)
    {
        $user = Auth::user();

        $course = Course::where('uuid', $courseUuid)
            ->with(['modules.classrooms.users' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->firstOrFail();

        if (!$course->certificate_enabled) {
            return redirect()->back()->with('error', 'Este curso não possui certificado habilitado.');
        }

        $totalClasses = $course->modules->sum(fn($m) => $m->classrooms->count());
        $completedClasses = $course->modules->flatMap->classrooms->filter(function ($aula) use ($user) {
            return $aula->users->contains($user->id);
        })->count();

        $progress = $totalClasses > 0 ? round(($completedClasses / $totalClasses) * 100) : 0;

        if ($progress < 95) {
            return redirect()->back()->with('error', 'Você precisa de pelo menos 95% de progresso para gerar o certificado. Seu progresso atual: ' . $progress . '%');
        }

        $validationCode = strtoupper(substr(md5($user->id . $course->id . now()), 0, 16));

        $signaturePath = storage_path('app/public/signatures/signature.png');
        $signature = file_exists($signaturePath) ? $signaturePath : null;

        $backgroundPath = null;
        if ($course->certificate_background) {
            $bg = storage_path('app/public/' . $course->certificate_background);
            if (file_exists($bg)) {
                $backgroundPath = $bg;
            }
        }

        $data = [
            'studentName' => $user->name,
            'courseName' => $course->title,
            'courseDescription' => $course->description,
            'completionDate' => now()->format('d/m/Y'),
            'workload' => $totalClasses . ' aulas',
            'validationCode' => $validationCode,
            'signature' => $signature,
            'background' => $backgroundPath,
        ];

        $pdf = Pdf::loadView('pdf.certificate', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('certificado_' . $course->uuid . '.pdf');
    }
}
