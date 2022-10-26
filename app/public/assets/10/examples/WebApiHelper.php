<?php

/**
 *
 * @author		Joris Maervoet
 * @copyright	Copyright (c), 2022 Joris Maervoet
 */
class WebApiHelper
{
    private string $verb;      // e.g. 'GET', 'POST', 'PUT', ...
    private string $path;      // e.g. 'api/lecturers'
    private ?array $httpBody;  // e.g. ["title" => "Oneplus 7T", "price" => 529.0, "quantity" => 200]

    public function __construct()
    {
        // Determination of the HTTP request verb
        $this->verb = $_SERVER['REQUEST_METHOD']; // e.g. 'GET', 'POST', 'PUT', ...

        // Determination of the HTTP request path (without path root)
        $fullPath = $_SERVER['REQUEST_URI']; // e.g. '/assets/10/examples/experiment/api/lecturers'
        $indexPhpPath = $_SERVER['SCRIPT_NAME']; // currently '/assets/10/examples/experiment/index.php'
        $pathPrefixLength = strrpos($indexPhpPath, '/') + 1; // length of '/assets/10/examples/experiment/'
        $this->path = substr($fullPath, $pathPrefixLength); // e.g. 'api/lecturers'
        // remove querystring from path
        if (($pos = strpos( $this->path, '?')) !== false) {
            $this->path = substr($this->path, 0, $pos);
        }

        // Parse the HTTP request body assuming it contains plain JSON
        // For example: {"title" : "Oneplus 7T", "price": 529.0, "quantity" : 200}
        // (If you want to parse application/x-www-form-urlencoded, use parse_str().)
        $this->httpBody = json_decode(file_get_contents('php://input'), true);

        // set the Content-type header of the HTTP response to JSON
        header('Content-type: application/json; charset=UTF-8');
    }

    /**
     * @return string
     */
    public function getVerb(): string
    {
        return $this->verb;
    }


    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $pattern simple regex; example 'lecturers/([0-9]+)'
     * @return bool
     */
    public function pathMatches(string $pattern): bool|array
    {
        $hasMatch = boolval(preg_match_all('#^' . $pattern . '$#', $this->path, $matches, PREG_OFFSET_CAPTURE));
        if ($hasMatch) {
            if (count($matches) > 1) {
                $matchValues = [];
                foreach ($matches as $key => $match) {
                    if ($key > 0) {
                        $matchValues[] = $match[0][0];
                    }
                }
                return $matchValues;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * @param string $pattern simple regex; example 'lecturers/([0-9]+)'
     * @return bool
     */
    public function matches(string $verb, string $pattern): bool|array
    {
        if ($this->verb === $verb) {
            return $this->pathMatches($pattern);
        }
        return false;
    }

    /**
     * @return array|null
     */
    public function getHttpBody(): ?array
    {
        return $this->httpBody;
    }

    public static function message(int $httpCode, string $message) {
        http_response_code($httpCode);
        $answer = ['message' => $message];
        echo json_encode($answer);
    }

}
