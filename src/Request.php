<?php

declare(strict_types=1);

namespace C14r\Directus;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;

class Request
{
    protected Client $client;

    protected string $endpoint;
    protected array $parameters = [];
    protected array $attributes = [];
    protected array $query = [];
    protected array $headers = [];

    /**
     * Constructor
     *
     * @param Directus $api The base URL
     */
    public function __construct(string $baseUrl)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
        ]);
    }

    /**
     * Sets the new endpoint.
     *
     * @param string $endpoint
     * @return self
     */
    public function endpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }
    
    /**
     * Sets a parameter for the request.
     *
     * @param string $key   The parameter
     * @param mixed $value  Value of the parameter
     * @return self
     */
    public function parameter(string $key, $value): self
    {
        return $this->set('parameters', $key, $value);
    }
    
    /**
     * Sets multiple parameters for the request.
     *
     * @param array|object $values A set of key-value-pairs.
     * @return self
     */
    public function parameters($values): self
    {
        return $this->setArray('parameters', $values);
    }

    /**
     * Sets a attribute for the request.
     *
     * @param string $key   The attribute
     * @param mixed $value  Value of the attribute
     * @return self
     */
    public function attribute($key, $value): self
    {
        return $this->set('attributes', $key, $value);
    }
    
    /**
     * Sets multiple attributes for the request.
     *
     * @param array|object $values A set of key-value-pairs.
     * @return self
     */
    public function attributes($values): self
    {
        return $this->setArray('attributes', $values);
    }

    /**
     * Sets a query-parameter for the request.
     *
     * @param string $key   The query-parameter
     * @param mixed $value  Value of the query-parameter
     * @return self
     */
    public function query($key, $value): self
    {
        return $this->set('query', $key, $value);
    }

    /**
     * Sets multiple query-parameters for the request.
     *
     * @param array|object $values A set of key-value-pairs.
     * @return self
     */
    public function queries($values): self
    {
        return $this->setArray('query', $values);
    }
    
    /**
     * Sets a header for the request.
     *
     * @param string $key   The header
     * @param mixed $value  Value of the header
     * @return self
     */
    public function header($key, $value): self
    {
        return $this->set('headers', $key, $value);
    }
    
    /**
     * Sets multiple headers for the request.
     *
     * @param array|object $values A set of key-value-pairs.
     * @return self
     */
    public function headers($values): self
    {
        return $this->setArray('headers', $values);
    }

    /**
     * Performs a POST-request (alias).
     *
     * @return object
     */
    public function create($data = []): object
    {
        return $this->attributes($data)->post();
    }

    /**
     * Performs a PATCH-request (alias).
     *
     * @return object
     */
    public function update($data = []): object
    {
        return $this->attributes($data)->patch();
    }

    /**
     * Performs a GET-request.
     *
     * @return object
     */
    public function get(): object
    {
        return $this->request('GET');
    }

    /**
     * Performs a POST-request.
     *
     * @return object
     */
    public function post(): object
    {
        return $this->request('POST');
    }

    /**
     * Performs a PATCH-request.
     *
     * @return object
     */
    public function patch(): object
    {
        return $this->request('PATCH');
    }

    /**
     * Performs a DELETE-request.
     *
     * @return object
     */
    public function delete(): object
    {
        return $this->request('DELETE');
    }

    /**
     * Performs the actual HTTP-request.
     *
     * @param string $method    HTTP-Method (GET, POST, PATCH, DELETE)
     * @param string $url       URL
     * @param array $options    Headers and data
     * @return ResponseInterface
     */
    protected function performRequest(string $method, string $url, array $options): ResponseInterface
    {
        try {
            return $this->client->request($method, $url, $options);
        } catch (ClientException $e) {
            return $e->getResponse();
        }
    }

    public function test(): object
    {
        return (object)[
            'url' => $this->buildUrl(),
            'options' => $this->buildOptions()
        ];
    }

    protected function request(string $method): object
    {
        $response = $this->performRequest($method, $this->buildUrl(), $this->buildOptions());
        $contents = $response->getBody()->getContents();
        $json = json_decode($contents);

        $this->clear();

        return is_null($json) ? (object)['data' => $contents] : $json;
    }

    /**
     * Builds the URL for the current request.
     *
     * @return string
     */
    protected function buildUrl(): string
    {
        return $this->replaceParameters($this->endpoint) . '?' . http_build_query($this->query);
    }

    /**
     * Prepares the request parameters
     *
     * @return array
     */
    protected function buildOptions(): array
    {
        return [
            'headers' => $this->headers,
            'query'   => $this->query,
            'json'    => $this->attributes
        ];
    }

    /**
     * Replace variables in the endpoint.
     *
     * @param string $endpoint
     * @return string
     */
    private function replaceParameters(string $endpoint): string
    {
        $url = $endpoint;

        foreach ($this->parameters as $key => $value) {
            $url = str_replace(':' . $key, $value, $url);
        }

        return $url;
    }

    /**
     * Sets a variable for the request.
     *
     * @param string $variable  Can be attributes, parameters, query, headers
     * @param string $key
     * @param mixed $value
     * @return self
     */
    private function set(string $variable, string $key, $value): self
    {
        if (!is_null($value)) {
            $this->{$variable}[$key] = $value;
        } elseif (is_null($value) and isset($this->{$variable}[$key])) {
            unset($this->{$variable}[$key]);
        }

        return $this;
    }

    /**
     * Sets multiple variables for the request.
     *
     * @param string $variable  Can be attributes, parameters, query, headers
     * @param array|object $array
     * @return self
     */
    private function setArray(string $variable, $array): self
    {
        foreach ($array as $key => $value) {
            $this->set($variable, $key, $value);
        }

        return $this;
    }

    /**
     * Clears all variables beloning to the last request.
     *
     * @return self
     */
    public function clear(): self
    {
        $this->endpoint = '';

        $this->parameters = [];
        $this->attributes = [];
        $this->query = [];
        $this->headers = [];
   
        return $this;
    }
}
