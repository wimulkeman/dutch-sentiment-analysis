<?php
use GuzzleHttp\Client;

/**
 * Created by IntelliJ IDEA.
 * User: wimulkeman
 * Date: 14-05-17
 * Time: 18:25
 */
class AzureConnection
{
    /**
     * The urls for the available APIs.
     */
    const TextAnalyseAPI = 'https://westus.api.cognitive.microsoft.com/text/analytics/v2.0/sentiment';

    /**
     * @var string
     */
    private $apiKey = '';

    /**
     * Assign a API key to use for the connection.
     *
     * @param string $apiKey
     *
     * @return AzureConnection
     */
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Make a request for a text sentiment analyse.
     *
     * @param string $textToAnalyse
     *
     * @return float
     */
    public function getTextSentimentAnalysis(string $textToAnalyse): float
    {
        $apiResponse = $this->requestApi(
            self::TextAnalyseAPI,
            ['documents' => [['id' => 1, 'language' => 'nl', 'text' => $textToAnalyse]]]
        );

        if (!$apiResponse) {
            throw new \RuntimeException('No response was recieved from the API call');
        }

        if (empty($apiResponse['documents'])) {
            throw new \RuntimeException('The API call returned a invalid data structure.');
        }

        return (float) $apiResponse['documents'][0]['score'];
    }

    /**
     * Request a API action.
     *
     * @param string $serviceUrl
     * @param array  $options
     *
     * @return array
     */
    private function requestApi(string $serviceUrl, array $options): array
    {
        $requestClient = new Client([
            'headers' => [
                'Ocp-Apim-Subscription-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);

        $response = $requestClient->request('POST', $serviceUrl, ['json' => $options, 'http_errors' => false]);

        if (empty($response)) {
            throw new \RuntimeException('The Azure API connection returned a blank response');
        }

        $json = json_decode($response->getBody(), true);
        if ($json === null) {
            throw new \RuntimeException('The Azure API connection returned a non-json response');
        }

        return $json;
    }
}