<?php
/**
 *
 */

namespace Guild\Http;


class Headers
{
    /**
     * @var array Array of header array information
     */
    protected $headers = array();

    /**
     * Add many headers at once
     * @param  array $headers
     */
    public function addHeaders($headers)
    {
        foreach ($headers as $name => $value) {
            $this->addHeaderLine($name, $value);
        }
    }


    /**
     * Add a raw header line
     * @param string $headerFieldNameOrLine
     * @param string $fieldValue
     */
    public function addHeaderLine($headerFieldNameOrLine, $fieldValue)
    {
        $headerName = $headerFieldNameOrLine;
        $line = $headerFieldNameOrLine . ': ' . $fieldValue;
        $this->headers[] = array('name' => $headerName, 'line' => $line);
    }

    /**
     * Return the headers container as an array
     * @return array
     */
    public function toArray()
    {
        return $this->headers;
    }
}