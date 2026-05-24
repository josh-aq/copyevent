<?php
require_once __DIR__ . '/../config/db.php';
header('Content-Type: application/json');

$in = json_decode(file_get_contents('php://input'), true) ?: [];
$event = $in['event'] ?? 'Event';
$budget = (int)($in['budget'] ?? 0);
$pax = (int)($in['pax'] ?? 0);
$services = $in['services'] ?? [];
$eventId = $in['eventId'] ?? null;
$regenerate = $in['regenerate'] ?? false;

// Event flow templates by type
$eventFlows = [
    'wedding' => [
        ['time' => '08:00 AM', 'activity' => 'Guest Arrival & Registration', 'prep' => 'Venue preparation, Coat check'],
        ['time' => '09:00 AM', 'activity' => 'Ceremony Starts', 'prep' => 'Bride entrance, vows, rings'],
        ['time' => '10:00 AM', 'activity' => 'Reception & Cocktail Hour', 'prep' => 'Photos, mingling, appetizers'],
        ['time' => '11:30 AM', 'activity' => 'Grand Entrance & First Dance', 'prep' => 'Music cues, lighting effects'],
        ['time' => '12:00 PM', 'activity' => 'Lunch Service', 'prep' => 'Multi-course meal service'],
        ['time' => '01:00 PM', 'activity' => 'Toasts & Speeches', 'prep' => 'Best man, bridesmaids, parents'],
        ['time' => '02:00 PM', 'activity' => 'Cake Cutting & Entertainment', 'prep' => 'Music, dancing, photo booth'],
        ['time' => '04:00 PM', 'activity' => 'Evening Activities & Dessert', 'prep' => 'DJ transitions, special dances'],
        ['time' => '06:00 PM', 'activity' => 'Farewell & Send-off', 'prep' => 'Guest departure arrangements'],
    ],
    'birthday' => [
        ['time' => '02:00 PM', 'activity' => 'Guest Arrival', 'prep' => 'Welcome drinks, games setup'],
        ['time' => '02:30 PM', 'activity' => 'Icebreaker Activities & Games', 'prep' => 'Team games, music playing'],
        ['time' => '03:30 PM', 'activity' => 'Snack Break', 'prep' => 'Light appetizers, drinks'],
        ['time' => '04:00 PM', 'activity' => 'Main Activities & Entertainment', 'prep' => 'DJ performance, dancing'],
        ['time' => '05:00 PM', 'activity' => 'Dinner Service', 'prep' => 'Main course buffet or plated meal'],
        ['time' => '06:00 PM', 'activity' => 'Birthday Cake & Singing', 'prep' => 'Special lighting, candles'],
        ['time' => '06:30 PM', 'activity' => 'Gifts & Photos', 'prep' => 'Gift opening, group photos'],
        ['time' => '07:30 PM', 'activity' => 'Dessert & Closing Activities', 'prep' => 'Dessert service, farewells'],
    ],
    'corporate' => [
        ['time' => '08:00 AM', 'activity' => 'Registration & Breakfast', 'prep' => 'Coffee, pastries, name badges'],
        ['time' => '09:00 AM', 'activity' => 'Opening Remarks', 'prep' => 'CEO/Director presentation'],
        ['time' => '09:30 AM', 'activity' => 'Keynote Speech', 'prep' => 'Main speaker presentation'],
        ['time' => '10:30 AM', 'activity' => 'Break & Networking', 'prep' => 'Refreshments, mingling'],
        ['time' => '11:00 AM', 'activity' => 'Breakout Sessions', 'prep' => 'Panel discussions, workshops'],
        ['time' => '12:00 PM', 'activity' => 'Lunch', 'prep' => 'Catered meal, table seating'],
        ['time' => '01:00 PM', 'activity' => 'Awards & Recognition', 'prep' => 'Recognition ceremony'],
        ['time' => '02:00 PM', 'activity' => 'Networking & Team Building', 'prep' => 'Games, activities, mingling'],
        ['time' => '04:00 PM', 'activity' => 'Closing Remarks & Departure', 'prep' => 'Thank you speech, farewell'],
    ],
    'graduation' => [
        ['time' => '09:00 AM', 'activity' => 'Guest Arrival & Seating', 'prep' => 'Program distribution, marshaling'],
        ['time' => '10:00 AM', 'activity' => 'Processional & Opening Ceremony', 'prep' => 'National anthem, prayers'],
        ['time' => '10:30 AM', 'activity' => 'Principal\'s Address', 'prep' => 'Opening remarks'],
        ['time' => '11:00 AM', 'activity' => 'Academic Presentations', 'prep' => 'Department heads, faculty speeches'],
        ['time' => '12:00 PM', 'activity' => 'Diploma Distribution', 'prep' => 'Graduates walking stage'],
        ['time' => '01:00 PM', 'activity' => 'Lunch Reception', 'prep' => 'Catered buffet, mingling'],
        ['time' => '02:00 PM', 'activity' => 'Photo Session & Celebrations', 'prep' => 'Family photos, celebrations'],
        ['time' => '04:00 PM', 'activity' => 'Farewell & Departure', 'prep' => 'Goodbyes, direction home'],
    ],
];

// Get event type flow
$eventType = strtolower($event);
$flow = null;

foreach ($eventFlows as $type => $timeline) {
    if (strpos($eventType, $type) !== false) {
        $flow = $timeline;
        break;
    }
}

// Default flow if no match
if (!$flow) {
    $flow = [
        ['time' => '09:00 AM', 'activity' => 'Event Start & Guest Arrival', 'prep' => 'Registration, welcome drinks'],
        ['time' => '10:00 AM', 'activity' => 'Opening Program', 'prep' => 'Opening remarks, introductions'],
        ['time' => '11:00 AM', 'activity' => 'Main Activities', 'prep' => 'Core event activities'],
        ['time' => '12:00 PM', 'activity' => 'Lunch Service', 'prep' => 'Food service to guests'],
        ['time' => '01:00 PM', 'activity' => 'Afternoon Program', 'prep' => 'Continued activities, entertainment'],
        ['time' => '03:00 PM', 'activity' => 'Snack & Break', 'prep' => 'Refreshment time'],
        ['time' => '04:00 PM', 'activity' => 'Closing Program', 'prep' => 'Final remarks, group photos'],
        ['time' => '05:00 PM', 'activity' => 'Farewell & Departure', 'prep' => 'Thank you, guest exit'],
    ];
}

// Build timeline HTML
$timelineHtml = '<h4 style="color: #f3c547; margin-top: 15px; margin-bottom: 10px;">📅 Recommended Event Timeline:</h4>';
foreach ($flow as $item) {
    $timelineHtml .= '<div class="timeline-item">';
    $timelineHtml .= '<div class="timeline-time">' . esc($item['time']) . '</div>';
    $timelineHtml .= '<div class="timeline-event"><strong>' . esc($item['activity']) . '</strong><br><small style="color: #999;">' . esc($item['prep']) . '</small></div>';
    $timelineHtml .= '</div>';
}

// Budget breakdown
$perPersonBudget = $pax > 0 ? round($budget / $pax, 2) : 0;
$budgetHtml = '<h4 style="color: #f3c547; margin-top: 20px; margin-bottom: 10px;">💰 Budget Breakdown:</h4>';
$budgetHtml .= '<p><strong>Total Budget:</strong> ₱' . number_format($budget, 2) . '</p>';
$budgetHtml .= '<p><strong>Per Person Budget:</strong> ₱' . number_format($perPersonBudget, 2) . '</p>';

// Service recommendations based on budget allocation
$serviceHtml = '<h4 style="color: #f3c547; margin-top: 20px; margin-bottom: 10px;">🎯 Recommended Services & Budget Allocation:</h4>';

$recommendations = [];
if (in_array('Venue', $services)) {
    $venueAlloc = round($budget * 0.30);
    $recommendations[] = '<div class="service-recommendation">🏛️ <strong>Venue Rental:</strong> ₱' . number_format($venueAlloc) . ' (30% of budget) - Look for venues within or near city centers</div>';
}
if (in_array('Catering', $services)) {
    $cateringAlloc = round($budget * 0.35);
    $recommendations[] = '<div class="service-recommendation">🍽️ <strong>Catering/Food:</strong> ₱' . number_format($cateringAlloc) . ' (35% of budget) - ₱' . number_format($cateringAlloc / $pax) . ' per person</div>';
}
if (in_array('Host', $services)) {
    $hostAlloc = round($budget * 0.08);
    $recommendations[] = '<div class="service-recommendation">🎤 <strong>Host/MC:</strong> ₱' . number_format($hostAlloc) . ' (8% of budget) - Professional host for smooth flow</div>';
}
if (in_array('Photographer', $services)) {
    $photoAlloc = round($budget * 0.10);
    $recommendations[] = '<div class="service-recommendation">📸 <strong>Photography:</strong> ₱' . number_format($photoAlloc) . ' (10% of budget) - Professional photos + digital copies</div>';
}
if (in_array('Sounds', $services)) {
    $soundAlloc = round($budget * 0.08);
    $recommendations[] = '<div class="service-recommendation">🎵 <strong>Sounds & Lights:</strong> ₱' . number_format($soundAlloc) . ' (8% of budget) - Quality audio and lighting rig</div>';
}
if (in_array('Clothing', $services)) {
    $clothingAlloc = round($budget * 0.05);
    $recommendations[] = '<div class="service-recommendation">👔 <strong>Attire:</strong> ₱' . number_format($clothingAlloc) . ' (5% of budget) - Styling coordination</div>';
}
if (in_array('Decorations', $services)) {
    $decorAlloc = round($budget * 0.04);
    $recommendations[] = '<div class="service-recommendation">🎨 <strong>Decorations:</strong> ₱' . number_format($decorAlloc) . ' (4% of budget) - Themed decor and setup</div>';
}

if (empty($recommendations)) {
    $recommendations[] = '<div class="service-recommendation">Select services to get budget allocation recommendations</div>';
}

$serviceHtml .= implode('', $recommendations);

// AI Enhancement via OpenAI if available
$aiNotes = '';
if (OPENAI_API_KEY && !$regenerate) {
    $prompt = "Create a brief (3-4 sentences) creative event planning tip for a $event with " . $pax . " guests and ₱" . number_format($budget) . " budget. Include one unique suggestion.";
    $payload = ["model" => "gpt-4o-mini", "messages" => [["role" => "user", "content" => $prompt]]];
    
    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/json", "Authorization: Bearer " . OPENAI_API_KEY],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);
    
    $raw = curl_exec($ch);
    $json = json_decode($raw, true);
    $tip = $json['choices'][0]['message']['content'] ?? '';
    
    if ($tip) {
        $aiNotes = '<h4 style="color: #f3c547; margin-top: 20px; margin-bottom: 10px;">💡 AI Planning Tips:</h4>';
        $aiNotes .= '<p style="background: rgba(243,197,71,0.08); padding: 12px; border-radius: 8px; border-left: 3px solid #f3c547; color: #333;">' . esc($tip) . '</p>';
    }
}

$html = '<div style="color: #333;">';
$html .= '<p><strong>Event Type:</strong> ' . esc($event) . ' | <strong>Guests:</strong> ' . $pax . ' | <strong>Budget:</strong> ₱' . number_format($budget, 2) . '</p>';
$html .= $timelineHtml;
$html .= $budgetHtml;
$html .= $serviceHtml;
$html .= $aiNotes;
$html .= '</div>';

echo json_encode(["html" => $html]);
?>