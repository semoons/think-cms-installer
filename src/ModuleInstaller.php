<?php
namespace cms\composer;

use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

class ModuleInstaller extends BaseInstaller
{

    /**
     * (non-PHPdoc)
     *
     * @see \Composer\Installer\LibraryInstaller::install()
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if ($this->composer->getPackage()->getType() == 'project') {
            
            // install
            parent::install($repo, $package);
            
            $install_path = $this->getInstallPath($package);
            try {
                
                // application
                $install_application_path = $install_path . DIRECTORY_SEPARATOR . 'application';
                if (is_dir($install_application_path)) {
                    $target_application_path = $this->getApplicationPath();
                    $this->filesystem->copyThenRemove($install_application_path, $target_application_path);
                }
                
                // public
                $install_public_path = $install_path . DIRECTORY_SEPARATOR . 'public';
                if (is_dir($install_public_path)) {
                    $target_public_path = $this->getPublicPath();
                    $this->filesystem->copyThenRemove($install_public_path, $target_public_path);
                }
                
                // extend
                $install_extend_path = $install_path . DIRECTORY_SEPARATOR . 'extend';
                if (is_dir($install_extend_path)) {
                    $target_extend_path = $this->getApplicationPath();
                    $this->filesystem->copyThenRemove($install_extend_path, $target_extend_path);
                }
                
                // common
                $extra = $package->getExtra();
                if (isset($extra['cms-module']) && isset($extra['cms-file'])) {
                    // dir
                    $common_path = $this->getCmsPath() . DIRECTORY_SEPARATOR . 'common';
                    $this->filesystem->ensureDirectoryExists($common_path);
                    
                    // copy
                    $common_file = $common_path . DIRECTORY_SEPARATOR . $extra['cms-module'] . '.php';
                    $this->filesystem->copyThenRemove($install_path . DIRECTORY_SEPARATOR . $extra['cms-file'], $common_file);
                }
            } catch (\Exception $e) {
                $this->io->write($e->getLine() . ':' . $e->getFile());
                $this->io->write($e->getMessage());
            }
            
            $this->filesystem->removeDirectory($install_path);
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Composer\Installer\LibraryInstaller::update()
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        if ($this->composer->getPackage()->getType() == 'project') {
            
            // update
            parent::update($repo, $initial, $target);
            
            $install_path = $this->getInstallPath($target);
            
            try {
                // application
                $install_application_path = $install_path . DIRECTORY_SEPARATOR . 'application';
                if (is_dir($install_application_path)) {
                    $target_application_path = $this->getApplicationPath();
                    $this->filesystem->copyThenRemove($install_application_path, $target_application_path);
                }
                
                // extend
                $install_extend_path = $install_path . DIRECTORY_SEPARATOR . 'extend';
                if (is_dir($install_extend_path)) {
                    $target_extend_path = $this->getExtendPath();
                    $this->filesystem->copyThenRemove($install_extend_path, $target_extend_path);
                }
                
                // public
                $install_public_path = $install_path . DIRECTORY_SEPARATOR . 'public';
                if (is_dir($install_public_path)) {
                    $target_public_path = $this->getPublicPath();
                    $this->filesystem->copyThenRemove($install_public_path, $target_public_path);
                }
                
                // common
                $extra = $target->getExtra();
                if (isset($extra['cms-module']) && isset($extra['cms-file'])) {
                    // dir
                    $common_path = $this->getCmsPath() . DIRECTORY_SEPARATOR . 'common';
                    $this->filesystem->ensureDirectoryExists($common_path);
                    
                    // copy
                    $common_file = $common_path . DIRECTORY_SEPARATOR . $extra['cms-module'] . '.php';
                    $this->filesystem->copyThenRemove($install_path . DIRECTORY_SEPARATOR . $extra['cms-file'], $common_file);
                }
            } catch (\Exception $e) {
                $this->io->write($e->getLine() . ':' . $e->getFile());
                $this->io->write($e->getMessage());
            }
            
            // remove install dir
            $this->filesystem->removeDirectory($install_path);
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Composer\Installer\LibraryInstaller::supports()
     */
    public function supports($packageType)
    {
        return 'think-cms-module' === $packageType;
    }
}