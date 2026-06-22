<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
            padding: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'serif';
            width: 297mm;
            height: 210mm;
            position: relative;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .background img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 80px;
            box-sizing: border-box;
            text-align: center;
        }
        .certificate-title {
            font-size: 48px;
            color: #1a365d;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 8px;
            margin-bottom: 10px;
        }
        .certificate-subtitle {
            font-size: 18px;
            color: #4a5568;
            margin-bottom: 40px;
            letter-spacing: 4px;
        }
        .certificate-text {
            font-size: 20px;
            color: #2d3748;
            margin-bottom: 10px;
        }
        .student-name {
            font-size: 42px;
            color: #1a365d;
            font-weight: bold;
            margin: 20px 0;
            font-family: 'serif';
            font-style: italic;
        }
        .course-name {
            font-size: 28px;
            color: #2b6cb0;
            font-weight: bold;
            margin: 15px 0;
        }
        .details {
            font-size: 16px;
            color: #4a5568;
            margin-top: 10px;
        }
        .signature-section {
            position: absolute;
            bottom: 50px;
            right: 80px;
            text-align: center;
        }
        .signature-section img {
            height: 60px;
            margin-bottom: 5px;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #2d3748;
            margin-bottom: 5px;
        }
        .validation {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 11px;
            color: #a0aec0;
            text-align: center;
        }
    </style>
</head>
<body>
    @if ($background)
        <div class="background">
            <img src="{{ $background }}" alt="Fundo do Certificado">
        </div>
    @endif

    <div class="content" style="background-color: {{ $background ? 'transparent' : '#f8f9fa' }};">
        <div class="certificate-title">Certificado</div>
        <div class="certificate-subtitle">de Conclusão</div>

        <div class="certificate-text">Certificamos que</div>
        <div class="student-name">{{ $studentName }}</div>
        <div class="certificate-text">concluiu com êxito o curso</div>
        <div class="course-name">{{ $courseName }}</div>
        <div class="details">
            Carga horária: {{ $workload }}<br>
            Data de conclusão: {{ $completionDate }}
        </div>
    </div>

    @if ($signature)
        <div class="signature-section">
            <img src="{{ $signature }}" alt="Assinatura">
            <div class="signature-line"></div>
            <div style="font-size: 12px; color: #4a5568;">Responsável</div>
        </div>
    @endif

    <div class="validation">
        Código de autenticação: {{ $validationCode }}<br>
        Verifique a autenticidade em {{ request()->getHost() }}
    </div>
</body>
</html>
