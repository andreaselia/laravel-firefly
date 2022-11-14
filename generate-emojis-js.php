<?php

require_once './vendor/autoload.php';

//replace with an access key obtained from https://emoji-api.com/
$accessKey = '';

$ch = curl_init('https://emoji-api.com/emojis?access_key='.$accessKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

$data = json_decode($response);

$emojis = collect();

foreach ($data as $emoji) {
    $keys = [$emoji->unicodeName];
    if ($emoji->group) {
        $keys[] = str_replace('-', ' ', $emoji->group);
    }
    if ($emoji->subGroup) {
        $keys[] = str_replace('-', ' ', $emoji->subGroup);
    }
    if (! $emojis->has($emoji->character)) {
        $emojis->put($emoji->character,
            [
                'emoji'    => $emoji->character,
                'keywords' => implode(',', $keys),
                'group'    => $emoji->group,
                'name'     => ucwords($emoji->unicodeName),
            ]);
    }
}

$groups = [
    ['emoji' => '😃', 'category' => 'Smileys', 'group' => 'smileys-emotion'],
    ['emoji' => '🐻', 'category' => 'Animals & Nature', 'group' => 'animals-nature'],
    ['emoji' => '🍔', 'category' => 'Food & Drink', 'group' => 'food-drink'],
    ['emoji' => '⚽', 'category' => 'Activity', 'group' => 'activities'],
    ['emoji' => '🚀', 'category' => 'Travel & Places', 'group' => 'travel-places'],
    ['emoji' => '💡', 'category' => 'Objects', 'group' => 'objects'],
    ['emoji' => '💕', 'category' => 'Symbols', 'group' => 'symbols'],
    ['emoji' => '🎌', 'category' => 'Flags', 'group' => 'flags'],
];

$content = [
    'categories' => $groups,
    'symbols'    => $emojis->values(),
];

$jsFile = 'window.EMOJIS = '.json_encode($content);

file_put_contents(dirname(__FILE__).'/resources/js/emojis.js', $jsFile);
