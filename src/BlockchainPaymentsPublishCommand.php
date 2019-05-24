<?php

namespace Arhx\BlockchainPayments;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class BlockchainPaymentsPublishCommand extends Command
{

	use DetectsApplicationNamespace;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blockchain-payments:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Integrate BlockchainPayments to laravel project';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$path = app_path('Http/Controllers/BlockchainPaymentController.php');
	    file_put_contents(
		    $path,
		    $this->compileControllerStub()
	    );
	    $this->line("Created Controller: $path");

	    $path = base_path('routes/api.php');
	    file_put_contents(
		    $path,
		    file_get_contents(__DIR__.'/stubs/routes/api.stub'),
		    FILE_APPEND
	    );
	    $this->line("Appended routes: $path");

	    $path = base_path('routes/web.php');
	    file_put_contents(
		    $path,
		    file_get_contents(__DIR__.'/stubs/routes/web.stub'),
		    FILE_APPEND
	    );
	    $this->line("Appended routes: $path");

	    $this->line("Publish other files:");
	    $this->call('vendor:publish', [
		    '--provider' => BlockchainPaymentsServiceProvider::class
	    ]);
    }

	/**
	 * Compiles the HomeController stub.
	 *
	 * @return string
	 */
	protected function compileControllerStub()
	{
		return str_replace(
			'{{namespace}}',
			$this->getAppNamespace(),
			file_get_contents(__DIR__.'/stubs/controllers/BlockchainPaymentController.stub')
		);
	}
}
