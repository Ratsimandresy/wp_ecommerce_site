<?php
namespace Depicter\Services;

use Averta\WordPress\Utility\JSON;
use Depicter\Exception\EntityException;
use Depicter\GuzzleHttp\Psr7\UploadedFile;

class ExportService
{

	/**
	 * Create zip file from slider data
	 *
	 * @param $documentID
	 *
	 * @return false|string
	 */
	public function pack( $documentID ) {

		$sliderData = $this->sliderData( $documentID );
		if ( !empty( $sliderData['data'] ) ) {
			$zip = new \ZipArchive();
			$tmp = tempnam('temp','zip');
			$zip->open( $tmp, \ZipArchive::OVERWRITE );
			$zip->addFromString( 'data.json', $sliderData['data'] );
			if ( !empty( $sliderData['assets'] ) ){
				foreach( $sliderData['assets'] as $assetID ){
					$attachmentUrl = wp_get_attachment_url( $assetID );
					$zip->addFromString( 'assets/' . get_the_title( $assetID ) . '-' . $assetID . '.' . pathinfo( $attachmentUrl, PATHINFO_EXTENSION ), file_get_contents( $attachmentUrl ) );
				}
			}
			$zip->close();
			return $tmp;
		}
		return false;
	}

	/**
	 * Get slider data
	 *
	 * @param $documentID
	 *
	 * @return array
	 */
	protected function sliderData( $documentID ) {
		try{
			$jsonContent = \Depicter::document()->getEditorData( $documentID );
			$jsonContent = JSON::encode( $jsonContent );
			$assetIDs = [];
			preg_match_all( '/\"source\":\"(\d+)\"/', $jsonContent, $assets, PREG_SET_ORDER );
			if ( !empty( $assets ) ) {
				foreach( $assets as $asset ) {
					if ( !empty( $asset[1] ) ) {
						$assetIDs[] = $asset[1];
					}
				}
			}
			return [
				'data' => $jsonContent,
				'assets' => $assetIDs
			];
		} catch( EntityException $e ){
			return [];
		}
	}
}
