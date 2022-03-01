<?php namespace Daycry\ReCaptcha\Commands;

use Config\Autoload;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;

class ReCaptchaPublish extends BaseCommand
{
    protected $group       = 'ReCaptcha';
    protected $name        = 'recaptcha:publish';
    protected $description = 'ReCaptcha config file publisher.';
    /**
     * The path to Daycry\RestServer\src directory.
     *
     * @var string
     */
    protected $sourcePath;
    //--------------------------------------------------------------------
    /**
     * Copy config file
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->determineSourcePath();
        $this->publishConfig();
        CLI::write('Config file was successfully generated.', 'green');       
    }
    //--------------------------------------------------------------------
    /**
     * Determines the current source path from which all other files are located.
     */
    protected function determineSourcePath()
    {
        $this->sourcePath = realpath(__DIR__ . '/../');
        if ($this->sourcePath == '/' || empty($this->sourcePath))
        {
            CLI::error('Unable to determine the correct source directory. Bailing.');
            exit();
        }
    }
    //--------------------------------------------------------------------
    /**
     * Publish config file.
     */
    protected function publishConfig()
    {
        $path = $this->sourcePath . '/Config/ReCaptcha2.php';
        $content = file_get_contents( $path );
        $content = str_replace( 'namespace Daycry\ReCaptcha\Config', 'namespace Config', $content );
        $content = str_replace( 'extends BaseConfig', 'extends \Daycry\ReCaptcha\Config\ReCaptcha2', $content );
        $this->writeFile( 'Config/ReCaptcha2.php', $content );

        $path = $this->sourcePath . '/Config/ReCaptcha3.php';
        $content = file_get_contents( $path );
        $content = str_replace( 'namespace Daycry\ReCaptcha\Config', 'namespace Config', $content );
        $content = str_replace( 'extends BaseConfig', 'extends \Daycry\ReCaptcha\Config\ReCaptcha3', $content );
        $this->writeFile( 'Config/ReCaptcha3.php', $content );
    }
    //--------------------------------------------------------------------
    /**
     * Write a file, catching any exceptions and showing a nicely formatted error.
     *
     * @param string $path
     * @param string $content
     */
    protected function writeFile(string $path, string $content)
    {
        $config = new Autoload();
        $appPath = $config->psr4[ APP_NAMESPACE ];
        $directory = dirname( $appPath . $path );
        if( !is_dir( $directory ) )
        {
            mkdir( $directory, 0777, true );
        }
        if( file_exists( $appPath . $path ) && CLI::prompt( 'Config file already exists, do you want to replace it?', [ 'y', 'n' ] ) == 'n' )
        {
            CLI::error('Cancelled');
            exit();
        }
        try
        {
            write_file($appPath . $path, $content);
        }
        catch (\Exception $e)
        {
            $this->showError($e);
            exit();
        }
        $path = str_replace( $appPath, '', $path );
        CLI::write( CLI::color( 'Created: ', 'yellow' ) . $path );
    }
    //--------------------------------------------------------------------
}