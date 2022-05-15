<?php
namespace Depicter\Controllers\Ajax;

use Averta\WordPress\Utility\Sanitize;
use WPEmerge\Requests\RequestInterface;

class ExportAjaxController
{
	protected $namePrefix = DEPICTER_PLUGIN_ID;

	/**
	 * @param RequestInterface $request
	 * @param                  $view
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function pack( RequestInterface $request, $view ) {
		$documentID = Sanitize::textfield( $request->query('id') );

		if ( empty( $documentID ) ) {
			return \Depicter::json([
				'errors' => ['Document ID is required.']
			])->withStatus(200);
		}

		$zip = \Depicter::exportService()->pack( $documentID );
		if ( $zip ) {
			$outputName = "{$this->namePrefix}-{$documentID}-" . gmdate("mdHis"). ".zip";
			header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'. $outputName .'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($zip));
		    readfile($zip);
			exit;
		}

		return \Depicter::json([
			'errors' => ['Error encountered']
		])->withStatus(200);
	}
}
