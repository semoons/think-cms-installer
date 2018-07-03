<?php
namespace cms\composer;

use Composer\Installer\LibraryInstaller;

class BaseInstaller extends LibraryInstaller
{

    /**
     * cms路径
     *
     * @return string
     */
    public function getCmsPath()
    {
        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (! empty($extra['cms-path'])) {
                return $extra['cms-path'];
            }
        }
        
        return 'thinkcms';
    }

    /**
     * application路径
     *
     * @return string
     */
    public function getApplicationPath()
    {
        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (! empty($extra['application-path'])) {
                return $extra['application-path'];
            }
        }
        
        return 'application';
    }

    /**
     * extend路径
     *
     * @return string
     */
    public function getExtendPath()
    {
        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (! empty($extra['extend-path'])) {
                return $extra['extend-path'];
            }
        }
        
        return 'extend';
    }

    /**
     * public路径
     *
     * @return string
     */
    public function getPublicPath()
    {
        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (! empty($extra['public-path'])) {
                return $extra['public-path'];
            }
        }
        
        return 'public';
    }
}