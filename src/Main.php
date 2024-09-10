<?php

declare( strict_types=1 );

namespace Milsorm\RuianImporter;

use GetOpt\ArgumentException;
use GetOpt\ArgumentException\Missing;
use GetOpt\GetOpt;
use GetOpt\Option;

final class Main
{

    private const NAME = 'ruian-importer';

    private const VERSION = '0.0.1';

    public function run (): void
    {
        $getOpt = $this->analyzeCommandLine();

        if ( $getOpt->getOption( 'download' ) ) {
            $this->downloadData();
        }
    }

    private function downloadData () : void {
        echo "Download data...\n";
    }

    private function analyzeCommandLine (): GetOpt
    {
        $getOpt = new GetOpt( [
            Option::create( NULL, 'version', GetOpt::NO_ARGUMENT )
                  ->setDescription( 'Show current program version.' ),
            Option::create( 'd', 'download', GetOpt::NO_ARGUMENT )
                  ->setDescription( 'Download current data from endpoint.' ),
            Option::create( 'h', 'help', GetOpt::NO_ARGUMENT )
                  ->setDescription( 'Show brief usage information.' ),
        ], [
            GetOpt::SETTING_STRICT_OPERANDS => TRUE,
            GetOpt::SETTING_STRICT_OPTIONS  => TRUE,
        ] );

        try {
            try {
                $getOpt->process();
            }
            catch ( Missing $exception ) {
                if ( ! $getOpt->getOption( 'help' ) ) {
                    throw $exception;
                }
            }
        }
        catch ( ArgumentException $exception ) {
            file_put_contents( 'php://stderr', $exception->getMessage() . PHP_EOL );
            echo PHP_EOL . $getOpt->getHelpText();
            exit;
        }

        if ( $getOpt->getOption( 'version' ) ) {
            echo sprintf( 'This is %s at version %s.' . PHP_EOL, self::NAME, self::VERSION );
            exit;
        }

        if ( $getOpt->getOption( 'help' ) || \count( $getOpt->getOptions() ) === 0 ) {
            echo $getOpt->getHelpText();
            exit;
        }

        return $getOpt;
    }

}
