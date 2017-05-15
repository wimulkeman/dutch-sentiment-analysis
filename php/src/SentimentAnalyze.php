<?php

/**
 * Created by IntelliJ IDEA.
 * User: wimulkeman
 * Date: 14-05-17
 * Time: 16:32
 */
class SentimentAnalyze
{
    /**
     * The available types of sentiment.
     */
    const POSITIVE_SENTIMENT = 'positive';
    const NEUTRAL_SENTIMENT = 'neutral';
    const NEGATIVE_SENTIMENT = 'negative';

    /**
     * @var string
     */
    private $analyzedSentiment = '';

    /**
     * @var float
     */
    private $sentimentScore = 0;

    /**
     * @var AzureConnection
     */
    private $analyzer;

    /**
     * @var array
     */
    private $error = ['msg' => ''];

    public function __construct($analyser)
    {
        $this->analyzer = $analyser;
    }

    /**
     * Provide the text which needs to be analyzed.
     *
     * @param string $text
     *
     * @return SentimentAnalyze
     */
    public function analyseText(string $text): SentimentAnalyze
    {
        try {
            $analyserScore = $this->analyzer->getTextSentimentAnalysis($text);
        } catch (\RuntimeException $exception) {
            throw $exception;
            $this->error['msg'] = 'An error occured during the call for a text sentiment analysis.';

            return $this;
        }

        if (!is_float($analyserScore)) {
            throw new \RuntimeException('The returned analyserScore should be a float value.');
        }

        $this->sentimentScore = $analyserScore;

        if ($analyserScore < 0.4) {
            $this->analyzedSentiment = self::NEGATIVE_SENTIMENT;
        } elseif ($analyserScore < 0.65) {
            $this->analyzedSentiment = self::NEUTRAL_SENTIMENT;
        } else {
            $this->analyzedSentiment = self::POSITIVE_SENTIMENT;
        }

        return $this;
    }

    public function isPositiveSentiment(): bool
    {
        return $this->analyzedSentiment === self::POSITIVE_SENTIMENT;
    }

    public function isNeutralSentiment(): bool
    {
        return $this->analyzedSentiment === self::NEUTRAL_SENTIMENT;
    }

    public function isNegativeSentiment(): bool
    {
        return $this->analyzedSentiment === self::NEGATIVE_SENTIMENT;
    }

    public function getDeducedSentiment()
    {
        return $this->analyzedSentiment;
    }

    public function getSentimentScore()
    {
        return $this->sentimentScore;
    }
}