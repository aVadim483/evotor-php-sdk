<?php

namespace avadim\Evotor;

use Psr\Http\Message\ResponseInterface;

class Response
{
    protected $response;
    protected $client;
    protected $filter;

    private $arr;

    public function __construct(Client $clnt, ResponseInterface $resp, $filter = null)
    {
        $this->client = $clnt;
        $this->response = $resp;
        $this->filter = $filter;
    }

    public function __toString()
    {
        return $this->response->getBody()->__toString();
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function toArray()
    {
        if (!$this->arr) {
            $data = json_decode((string)$this->response->getBody(), true);
            $this->arr = $data['items'] ?? $data;
        }
        /*
        if($this->filter) {
            if($this->arr) {
                foreach($this->arr as $item) {
                    if($item && isset($item['id'])) {
                        if(strtolower($item['id']) == strtolower($this->filter)) {
                            return $item;
                        }
                    }
                }
            }
        }
        */
        return $this->arr;
    }

    public function first()
    {
        return $this->toArray()[0] ?? null;
    }

    /**
     * Проксирует вызовы в Collection, построенную из данных ответа
     *
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        $collection = Collection::from($this->toArray() ?: []);
        if (!method_exists($collection, $name)) {
            throw new Exception('Unknown method '.$name.'() of '.Collection::class);
        }

        return call_user_func_array([$collection, $name], $arguments);
    }
}
