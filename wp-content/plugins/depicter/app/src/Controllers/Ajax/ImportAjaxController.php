<?php
namespace Depicter\Controllers\Ajax;

use GuzzleHttp\Psr7\UploadedFile;
use WPEmerge\Requests\RequestInterface;

class ImportAjaxController
{

	/**
	 * @param RequestInterface $request
	 * @param                  $view
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function unpack( RequestInterface $request, $view ) {
		$zipFile = $request->files('file');

		if ( empty( $zipFile ) || ! $zipFile instanceof UploadedFile ) {
			return \Depicter::json([
				'errors' => [ 'No file provided to upload']
			])->withStatus(400 );
		}

		if ( $zipFile->getError() ) {
			return \Depicter::json([
                   'errors'        => [
                       sprintf( __( 'Cannot upload the file, because max permitted file upload size is %s.', PLUGIN_DOMAIN ), ini_get('upload_max_filesize') )
                   ]
			]);
		}

		if( $zipFile->getClientMediaType() != 'application/zip' ){
			return \Depicter::json([
                'errors' => [ 'Provided file must be zip file.']
			])->withStatus(400 );
		}

		if ( \Depicter::importService()->unpack($zipFile) ) {
			return \Depicter::json([
               'success' => [ 'Slider imported successfully']
           ])->withStatus(200 );
		} else {
			return \Depicter::json([
               'errors' => [ 'Error occurred during import process.']
           ])->withStatus(400 );
		}
	}
}
