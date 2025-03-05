<?php
class PythonConfigManager {
    private $configData = [];
    private $path = '';
    public function __construct($filePath) {
        $this->loadConfig($filePath);
        $this->path = $filePath;
    }

    private function loadConfig($filePath) {
        if (file_exists($filePath)) {
            $configContent = file_get_contents($filePath);
            preg_match_all('/(\w+)\s*=\s*(.*?)(?=\s*\n|\Z)/s', $configContent, $matches);

            foreach ($matches[1] as $key => $variable) {
                $this->configData[$variable] = $this->parseValue(trim($matches[2][$key]));
            }
        } else {
            throw new Exception("File not found: $filePath");
        }
    }

    private function parseValue($value) {
        if (strtolower($value) === 'True') {
            return true;
        }
        if (strtolower($value) === 'False') {
            return false;
        }
        if (is_numeric($value)) {
            return (strpos($value, '.') !== false) ? floatval($value) : intval($value);
        }
        if (preg_match('/^\[.*\]$/s', $value)) {
            return json_decode($value);
        }
        if (preg_match('/^{.*}$/s', $value)) {
            return json_decode(str_replace(['True','False'],['true','false'],$value));
        }
        return json_decode($value);
    }

    private function saveConfig($filePath) {
        $configStr = '';
        foreach ($this->configData as $key => $value) {
            if(is_object($value)){
                $value = (array)$value;
            }
            if(!empty($value)) {
                $configStr .= "$key = " . $this->formatValue($value) . "\n";
            }
        }
        file_put_contents($filePath, $configStr);
    }

    private function formatValue($value) {
        if (is_bool($value)) {
            return $value ? 'True' : 'False';
        }
        if (is_int($value)) {
            return $value;
        }
        if (is_array($value) || is_object($value)) {
            return str_replace(['true','false'],['True','False'],json_encode($value,320));
        }
        return json_encode($value,320);
    }

    public function cleanConfig() {
        $this->saveConfig($this->path);
    }

    public function getConfig() {
        return $this->configData;
    }

    public function __get($name) {
        if (isset($this->configData[$name])) {
            return $this->configData[$name];
        }
        throw new Exception("Property '$name' not found.");
    }

    public function __set($name, $value) {
        $this->configData[$name] = $value;
    }

    public function __isset($name) {
        return isset($this->configData[$name]);
    }

    public function __unset($name) {
        if (isset($this->configData[$name])) {
            unset($this->configData[$name]);
        }
    }
}