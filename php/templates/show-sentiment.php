<?php
$deducedSentiment = $sentimentAnalyzer->getDeducedSentiment();

$dutchSentimentTranslation = '';
switch ($deducedSentiment) {
    case $sentimentAnalyzer::POSITIVE_SENTIMENT:
        $dutchSentimentTranslation = 'positief';
        break;
    case $sentimentAnalyzer::NEUTRAL_SENTIMENT:
        $dutchSentimentTranslation = 'neutraal';
        break;
    case $sentimentAnalyzer::NEGATIVE_SENTIMENT:
        $dutchSentimentTranslation = 'negatief';
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sentiment resultaat - <?php echo $dutchSentimentTranslation; ?></title>
</head>
<body>
<p>
    Het ingeschatte sentiment is <?php echo $dutchSentimentTranslation; ?> met een score van <?php echo $sentimentAnalyzer->getSentimentScore(); ?>.
</p>
<?php
if ($sentimentAnalyzer->isPositiveSentiment()) {
    // TODO Show happy smiley image
    echo '<img src="assets/img/happy-smiley.png">';
} elseif ($sentimentAnalyzer->isNeutralSentiment()) {
    // TODO Show neutral smiley
    echo '<img src="assets/img/neutral-smiley.png">';
} else {
    // Todo Show sad smiley
    echo '<img src="assets/img/sad-smiley.png">';
}
?>
<p>
    Probeer het <a href="./">opnieuw</a>
</p>
<p>
    De genaliseerde tekst was:
</p>
<p style="font-style: italic">
    "<?php echo $_POST['text']; ?>"
</p>
</body>
</html>