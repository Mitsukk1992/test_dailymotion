<?php

namespace Core\Env;

use Core\Exceptions\EnvLoaderException;

class EnvLoader
{
    public function loadEnv($envPath)
    {
        try {
            $file = new \SplFileObject($envPath);
            $rawEnv = $this->loadRawEnv($file);
            $this->saveEnv($rawEnv);
        } catch (\LogicException $e) {
            throw new EnvLoaderException('EnvLoaderException - Cannot load env', $e->getCode(), $e);
        } catch (\RuntimeException $e) {
            //File cannot be open. Ignore env
        } finally {
            //Free fd
            $rawEnv = null;
        }
    }

    private function loadRawEnv(\SplFileObject $file) : array
    {
        $rawEnv = [];

        while ($file->valid()) {
            $line = $file->fgets();
            if (strlen($line) > 0) {
                $parsedLine = $this->parseLine($line);
                $rawEnv += $parsedLine;
            }
        }

        return $rawEnv;
    }

    private function saveEnv(array $rawEnv)
    {
        $phpEnv = $_ENV;

        $_ENV = $phpEnv + $rawEnv;
    }

    private function parseLine(string $line) : array
    {
        $line = preg_replace("/(.*?)#(.*)/", "$1", $line);
        $explodeLine = explode('=', $line);

        $lengthExplodeLine = count($explodeLine);
        if ($lengthExplodeLine !== 2) {
            return [];
        }

        //Remove \n from string
        foreach ($explodeLine as $key => $value) {
            $value = trim(preg_replace('/\s+/', ' ', $value));

            $explodeLine[$key] = $value;
        }


        return [$explodeLine[0] => $explodeLine[1]];
    }
}