@php
    $stats = [
        'vida'         => ['color' => '#34d399', 'label' => 'Vida'],
        'armadura'     => ['color' => '#d1d5db', 'label' => 'Armadura'],
        'determinacao' => ['color' => '#a78bfa', 'label' => 'Determinação'],
        'folego'       => ['color' => '#67e8f9', 'label' => 'Fôlego'],
        'resistencia'  => ['color' => '#fbbf24', 'label' => 'Resistência'],
    ];
@endphp
@foreach($stats as $key => $data)
    <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.07);padding:10px 0;">
        <span style="font-size:10px;font-weight:900;color:#666;text-transform:uppercase;letter-spacing:2px;">{{ $data['label'] }}</span>
        <span style="font-size:28px;font-weight:900;color:{{ $data['color'] }};font-family:monospace;">{{ $ficha->$key ?? 0 }}</span>
    </div>
@endforeach