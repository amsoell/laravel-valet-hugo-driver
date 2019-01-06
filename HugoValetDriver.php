<?php

class HugoValetDriver extends ValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     * @return void
     */
    public function serves($sitePath, $siteName, $uri)
    {
        if ((file_exists($sitePath . '/config.toml') ||
            file_exists($sitePath . '/config.yaml') ||
            file_exists($sitePath . '/config.json')) &&
            file_exists($sitePath . '/public')
            ) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string       $sitePath
     * @param  string       $siteName
     * @param  string       $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if ( file_exists( $staticPath = $sitePath . '/' . $this->getServingFolderName() . $uri ) && ! is_dir($staticPath) ) {
            return $staticPath;
        } elseif ( file_exists( $fauxPath = $staticPath . '/' . $this->getServingFileName() ) ) {
            return $fauxPath;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string $sitePath
     * @param  string $siteName
     * @param  string $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        return $sitePath . '/' . $this->getServingFolderName() . '/' . $this->getServingFileName();
    }

    private function getServingFolderName()
    {
        return 'public';
    }

    private function getServingFileName()
    {
        return 'index.html';
    }
}
