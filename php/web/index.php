<?php
/**
 * Created by IntelliJ IDEA.
 * User: wimulkeman
 * Date: 14-05-17
 * Time: 16:33
 */
if (empty($_POST['text'])) {
    include '../templates/sentiment-form.html';
    return;
}

include_once "../vendor/autoload.php";

include_once '../src/AzureConnection.php';
include_once '../src/SentimentAnalyze.php';

include_once '../resources/include/parameters.php';

$azureConnection = new AzureConnection();
$azureConnection->setApiKey(AZURE_API_KEY);

$sentimentAnalyzer = new SentimentAnalyze($azureConnection);
$sentimentAnalyzer->analyseText($_POST['text']);

include '../templates/show-sentiment.php';
