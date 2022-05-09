<?php

namespace App\Service;

use App\Interfaces\CustomHttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Exception;

class CustomHttpClient implements CustomHttpClientInterface
{
    protected HttpClientInterface $_httpClient;
    protected int $_statusCode;
    protected array $_errorMessages = [];

    public function __construct()
    {
        $this->_httpClient = HttpClient::create();
        $this->_setStatusCode();
    }

    protected function _setStatusCode($code = -1): void{
        $this->_statusCode = $code;
    }

    protected function _getStatusCode(): int
    {
        return $this->_statusCode;
    }

    public function getErrorMessages(): array
    {
        return $this->_errorMessages;
    }

    protected function _setErrorMessage($key, $message): void
    {
        $this->_errorMessages[$key] = $message;
    }

    public function getUrlCode(string $url): int
    {
        try{
            $response = $this->_httpClient->request('GET', $url);
            $this->_setStatusCode($response->getStatusCode());
            return $this->_getStatusCode();
        } catch (Exception $e) {
            $this->_setErrorMessage('HttpExceptionMessage', $e->getMessage());
            return $this->_getStatusCode();
        } catch (TransportExceptionInterface $e) {
            $this->_setErrorMessage('TransportExceptionMessage', $e->getMessage());
            return $this->_getStatusCode();
        }

    }
}