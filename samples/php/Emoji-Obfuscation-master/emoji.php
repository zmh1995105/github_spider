<?php

echo '<form action="emoji.php" method="POST">';
echo '<p>Input text: <input type="text" name="textEmoji" value="" style="width:100%;" /></p>';
echo '<p><button type="submit" name="emoji">Emoji</button>';
echo '<button type="submit" name="alpha">Alpha</button></p>';

if(isset($_POST['alpha']) or isset($_POST['emoji']))
{
    $array_emoji = [
        'a' => '🅰️',
        'b' => '🅱️',
        'c' => '©',
        'd' => '↩',
        'e' => '📧',
        'f' => '🚩',
        'g' => '🌀',
        'h' => '♓',
        'i' => 'ℹ',
        'j' => '🎷',
        'k' => '🎋',
        'l' => '👢',
        'm' => 'Ⓜ',
        'n' => '♑',
        'o' => '🅾️',
        'p' => '🅿️',
        'q' => '♎',
        'r' => '®',
        's' => '⚡',
        't' => '🌴',
        'u' => '⛎',
        'v' => '✔',
        'w' => '〰',
        'x' => '❌',
        'y' => '✌',
        'z' => 'Ⓩ',
        '0' => '0️⃣',
        '1' => '1️⃣',
        '2' => '2️⃣',
        '3' => '3️⃣',
        '4' => '4️⃣',
        '5' => '5️⃣',
        '6' => '6️⃣',
        '7' => '7️⃣',
        '8' => '8️⃣',
        '9' => '9️⃣',
        '!' => '❗',
        '?' => '❓',
        '$' => '💲',
        '+' => '➕',
        '-' => '➖',
        '/' => '➗',
        '<' => '◀',
        '>' => '▶',
        '*' => '*️⃣',
        ';' => '🕹',
        ':' => '🚦',
        '(' => '📈',
        ')' => '📉',
        '\'' => '💧',
        '"' => '💦',
        '.' => '⏺',
    ];


    if(isset($_POST['emoji']))
    {
        $aEmoji = array_keys($array_emoji);
        $eEmoji = array_values($array_emoji);

        $out = str_replace($aEmoji, $eEmoji, $_POST['textEmoji']);
        echo 'Emoji:' . PHP_EOL . $out;
    }

    if(isset($_POST['alpha']))
    {
        $aEmoji = array_values($array_emoji);
        $eEmoji = array_keys($array_emoji);


        $out = str_replace($aEmoji, $eEmoji, $_POST['textEmoji']);
        echo 'Alfabeto:' . PHP_EOL . $out;
    }

}

